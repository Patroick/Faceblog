<?php

namespace Infrastructure;

use Application\Interfaces\StatisticsRepository;

final class DatabaseRepository implements StatisticsRepository
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
        $connection = $this->getConnection();
        $result = $this->executeQuery($connection, "SELECT COUNT(*) as count FROM users");
        $row = $result->fetch_assoc();
        $connection->close();
        return (int)$row['count'];
    }

    public function getTotalBlogEntriesCount(): int
    {
        $connection = $this->getConnection();
        $result = $this->executeQuery($connection, "SELECT COUNT(*) as count FROM blog_entries");
        $row = $result->fetch_assoc();
        $connection->close();
        return (int)$row['count'];
    }

    public function getRecentBlogEntriesCount(): int
    {
        $connection = $this->getConnection();
        $result = $this->executeQuery($connection, "SELECT COUNT(*) as count FROM blog_entries WHERE created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)");
        $row = $result->fetch_assoc();
        $connection->close();
        return (int)$row['count'];
    }

    public function getLastPostDate(): ?string
    {
        $connection = $this->getConnection();
        $result = $this->executeQuery($connection, "SELECT MAX(created_at) as last_date FROM blog_entries");
        $row = $result->fetch_assoc();
        $connection->close();
        return $row['last_date'];
    }
} 