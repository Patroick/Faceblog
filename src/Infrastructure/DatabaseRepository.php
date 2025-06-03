<?php

namespace Infrastructure;

use Application\Interfaces\StatisticsRepository;
use Application\Interfaces\UserRepository;

final class DatabaseRepository implements StatisticsRepository, UserRepository
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

    private function executeQuery(\mysqli $connection,string $query)
    {
        $result = $connection->query($query);
        if (!$result) {
            die("Error in query '$query' :" . $connection->error);
        }
        return $result;

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
        $r = $this->executeStatement($con, "SELECT id, username, password_hash FROM users WHERE id = ?",
            function ($s) use ($userId) {
                $s->bind_param("i", $userId);
            });
        
        $r->bind_result($id, $username, $passwordHash);
        $res = null;
        
        if ($r->fetch()) {
            $res = new \Application\Entities\User($id, $username, $passwordHash);
        }

        $r->close();
        $con->close();
        return $res;
    }

    public function getUserByUserName(string $userName): ?\Application\Entities\User
    {
        $con = $this->getConnection();
        $r = $this->executeStatement($con, "SELECT id, username, password_hash FROM users WHERE username = ?",
            function ($s) use ($userName) {
                $s->bind_param("s", $userName);
            });
        
        $r->bind_result($id, $username, $passwordHash);
        $res = null;
        
        if ($r->fetch()) {
            $res = new \Application\Entities\User($id, $username, $passwordHash);
        }

        $r->close();
        $con->close();
        return $res;
    }
} 