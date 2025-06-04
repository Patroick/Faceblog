<?php

namespace Infrastructure;

use Application\Interfaces\StatisticsRepository;
use Application\Interfaces\UserRepository;
use Application\Interfaces\BlogRepository;

final class DatabaseRepository implements StatisticsRepository, UserRepository, BlogRepository
{
    public function __construct(
        private string $server,
        private string $userName,
        private string $password,
        private string $database
    ) {}

    private function getConnection(): \mysqli{
        $con = new \mysqli($this->server, $this->userName, $this->password, $this->database);
        if (!$con) {
            die("Unable to connect to database. Error: " . mysqli_connect_error());
        }
        return $con;
    }

    private function executeStatement(\mysqli $connection,string $query, callable $bindFunc)
    {
        $statement = $connection->prepare($query);
        if (!$statement) {
            die("Error in prepared statement '$query' :" . $connection->error);
        }
        $bindFunc($statement);
        if (!$statement->execute()) {
            die("Error executing prepared statement '$query' :" . $statement->error);
        }
        return $statement;
    }

    public function getTotalUserCount(): int
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT COUNT(*) as count FROM users", function($s) {});
        
        $r->bind_result($count);
        $result = 0;
        
        if ($r->fetch()) {
            $result = (int)$count;
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function getTotalBlogEntriesCount(): int
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT COUNT(*) as count FROM blog_entries", function($s) {});
        
        $r->bind_result($count);
        $result = 0;
        
        if ($r->fetch()) {
            $result = (int)$count;
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function getRecentBlogEntriesCount(): int
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT COUNT(*) as count FROM blog_entries WHERE created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)", function($s) {});
        
        $r->bind_result($count);
        $result = 0;
        
        if ($r->fetch()) {
            $result = (int)$count;
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function getLastPostDate(): ?string
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT MAX(created_at) as last_date FROM blog_entries", function($s) {});
        
        $r->bind_result($lastDate);
        $result = null;
        
        if ($r->fetch()) {
            $result = $lastDate;
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function getUser(int $userId): ?\Application\Entities\User
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT id, username, display_name, password_hash, created_at FROM users WHERE id = ?",
            function ($s) use ($userId) {
                $s->bind_param("i", $userId);
            });
        
        $r->bind_result($id, $username, $displayName, $passwordHash, $createdAt);
        $res = null;
        
        if ($r->fetch()) {
            $res = new \Application\Entities\User($id, $username, $passwordHash, $displayName, $createdAt);
        }

        $r->close();
        $con->close();
        return $res;
    }

    public function getUserByUserName(string $userName): ?\Application\Entities\User
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT id, username, display_name, password_hash, created_at FROM users WHERE username = ?",
            function ($s) use ($userName) {
                $s->bind_param("s", $userName);
            });
        
        $r->bind_result($id, $username, $displayName, $passwordHash, $createdAt);
        $res = null;
        
        if ($r->fetch()) {
            $res = new \Application\Entities\User($id, $username, $passwordHash, $displayName, $createdAt);
        }

        $r->close();
        $con->close();
        return $res;
    }

    public function addUser(string $username, string $passwordHash, string $displayName): void
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "INSERT INTO users (username, display_name, password_hash) VALUES (?, ?, ?)",
            function ($s) use ($username, $passwordHash, $displayName) {
                $s->bind_param("sss", $username, $displayName, $passwordHash);
            });
        
        $r->close();
        $con->close();
    }

    public function isUsernameAvailable(string $username): bool
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT COUNT(*) as count FROM users WHERE username = ?",
            function ($s) use ($username) {
                $s->bind_param("s", $username);
            });
        
        $r->bind_result($count);
        $result = true;
        
        if ($r->fetch()) {
            $result = (int)$count === 0;
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function getBlogEntriesByUserId(int $userId): array
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT id, user_id, subject, content, created_at FROM blog_entries WHERE user_id = ? ORDER BY created_at DESC",
            function ($s) use ($userId) {
                $s->bind_param("i", $userId);
            });
        
        $r->bind_result($id, $user_id, $subject, $content, $created_at);
        $result = [];
        
        while ($r->fetch()) {
            $result[] = new \Application\Entities\BlogEntry($id, $user_id, $subject, $content, $created_at);
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function addBlogEntry(int $userId, string $subject, string $content): void
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "INSERT INTO blog_entries (user_id, subject, content) VALUES (?, ?, ?)",
            function ($s) use ($userId, $subject, $content) {
                $s->bind_param("iss", $userId, $subject, $content);
            });
        
        $r->close();
        $con->close();
    }

    public function searchUsersByDisplayName(string $searchTerm): array
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT id, username, display_name, password_hash, created_at FROM users WHERE display_name LIKE ? ORDER BY display_name",
            function ($s) use ($searchTerm) {
                $likeSearchTerm = '%' . $searchTerm . '%';
                $s->bind_param("s", $likeSearchTerm);
            });
        
        $r->bind_result($id, $username, $displayName, $passwordHash, $createdAt);
        $result = [];
        
        while ($r->fetch()) {
            $result[] = new \Application\Entities\User($id, $username, $passwordHash, $displayName, $createdAt);
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function toggleLike(int $userId, int $blogEntryId): void
    {
        $con = $this->getConnection();
        
        if ($this->hasUserLiked($userId, $blogEntryId)) {
            $r = $this->executeStatement($con, "DELETE FROM likes WHERE user_id = ? AND blog_entry_id = ?",
                function ($s) use ($userId, $blogEntryId) {
                    $s->bind_param("ii", $userId, $blogEntryId);
                });
        } else {
            $r = $this->executeStatement($con, "INSERT INTO likes (user_id, blog_entry_id) VALUES (?, ?)",
                function ($s) use ($userId, $blogEntryId) {
                    $s->bind_param("ii", $userId, $blogEntryId);
                });
        }
        
        $r->close();
        $con->close();
    }

    public function getLikeCount(int $blogEntryId): int
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT COUNT(*) as count FROM likes WHERE blog_entry_id = ?",
            function ($s) use ($blogEntryId) {
                $s->bind_param("i", $blogEntryId);
            });
        
        $r->bind_result($count);
        $result = 0;
        
        if ($r->fetch()) {
            $result = (int)$count;
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function hasUserLiked(int $userId, int $blogEntryId): bool
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT COUNT(*) as count FROM likes WHERE user_id = ? AND blog_entry_id = ?",
            function ($s) use ($userId, $blogEntryId) {
                $s->bind_param("ii", $userId, $blogEntryId);
            });
        
        $r->bind_result($count);
        $result = false;
        
        if ($r->fetch()) {
            $result = (int)$count > 0;
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function getUsersWhoLiked(int $blogEntryId): array
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT u.id, u.username, u.display_name, u.password_hash, u.created_at FROM users u INNER JOIN likes l ON u.id = l.user_id WHERE l.blog_entry_id = ? ORDER BY u.display_name",
            function ($s) use ($blogEntryId) {
                $s->bind_param("i", $blogEntryId);
            });
        
        $r->bind_result($id, $username, $displayName, $passwordHash, $createdAt);
        $result = [];
        
        while ($r->fetch()) {
            $result[] = new \Application\Entities\User($id, $username, $passwordHash, $displayName, $createdAt);
        }

        $r->close();
        $con->close();
        return $result;
    }

    public function deleteBlogEntry(int $blogEntryId, int $userId): bool
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "DELETE FROM blog_entries WHERE id = ? AND user_id = ?",
            function ($s) use ($blogEntryId, $userId) {
                $s->bind_param("ii", $blogEntryId, $userId);
            });
        
        $deleted = $r->affected_rows > 0;
        $r->close();
        $con->close();
        return $deleted;
    }
} 