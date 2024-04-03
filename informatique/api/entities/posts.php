<?php

class Post
{
    public $post_id;
    public $user_id;
    public $responding_to_id;
    public $created_at;
    public $title;
    public $content;

    /**
     * @var UserModel
     */
    public $user;
}

class PostAPI
{
    private $pdo;

    /**
     * @var UserAPI
     */
    private $userAPI;

    public function __construct($pdo, $userAPI)
    {
        $this->pdo = $pdo;
        $this->userAPI = $userAPI;
    }

    public function toPost($row)
    {
        $post = new Post();
        $post->title = $row['title'];
        $post->post_id = $row['post_id'];
        $post->user_id = $row['user_id'];
        $post->responding_to_id = $row['responding_to_id'];
        $post->created_at = $row['created_at'];
        $post->content = $row['content'];

        $post->user = $this->userAPI->getUserById($post->user_id);
        return $post;
    }

    public function getPostById($post_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Posts WHERE post_id = :post_id");
        $stmt->execute(['post_id' => $post_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->toPost($row);
    }

    public function getResponseOfPost($post_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Posts WHERE responding_to_id = :post_id ORDER BY created_at DESC");
        $stmt->execute(['post_id' => $post_id]);
        $posts = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = $this->toPost($row);
        }

        return $posts;
    }

    public function createPost($user_id, $title, $content, $responding_to_id = null)
    {
        $post_id = uniqid();
        $stmt = $this->pdo->prepare("INSERT INTO Posts (post_id, user_id, responding_to_id, title, content) VALUES (:post_id, :user_id, :responding_to_id, :title, :content)");
        $stmt->execute([
            'post_id' => $post_id,
            'user_id' => $user_id,
            'responding_to_id' => $responding_to_id,
            'title' => $title,
            'content' => $content
        ]);

        return $post_id;
    }

    public function editPost($post_id, $content)
    {
        $stmt = $this->pdo->prepare("UPDATE Posts SET content = :content WHERE post_id = :post_id");
        $stmt->execute([
            'content' => $content,
            'post_id' => $post_id
        ]);

        return $stmt->rowCount() > 0;
    }

    // order by date desc

    public function getAllPostsNotResponding()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Posts WHERE responding_to_id IS NULL ORDER BY created_at DESC");
        $stmt->execute();
        $posts = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = $this->toPost($row);
        }

        return $posts;
    }

    public function getAllPostsNotRespondingFilter($word = null, $username = null)
    {
        $sql = "SELECT * FROM Posts WHERE responding_to_id IS NULL";


        if ($word !== null && $username !== null) {
            $sql .= " AND (content LIKE :word OR title LIKE :word) AND user_id IN (SELECT user_id FROM Users WHERE first_name LIKE :username OR last_name LIKE :username)";
        } elseif ($word !== null) {
            $sql .= " AND (content LIKE :word OR title LIKE :word)";
        } elseif ($username !== null) {
            $sql .= " AND user_id IN (SELECT user_id FROM Users WHERE first_name LIKE :username OR last_name LIKE :username)";
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);

        $params = [];

        if ($word !== null) {
            $params['word'] = "%$word%";
        }

        if ($username !== null) {
            $params['username'] = "%$username%";
        }

        $stmt->execute($params);
        $posts = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = $this->toPost($row);
        }

        return $posts;
    }
}

const QUERY_CREATE_TABLE_POSTS = "CREATE TABLE Posts (
    post_id VARCHAR(255) PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    responding_to_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    content TEXT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (responding_to_id) REFERENCES Posts(post_id)
);";

const QUERY_DEFAULT_POSTS = "INSERT INTO Posts (post_id, user_id, responding_to_id, content) VALUES
('1', '6606932a09bb9', NULL, 'This is the first post.'),
('2', '6606932a09bb9', NULL, 'Hello everyone!'),
('3', '6606932a09bb9', '1', 'Reply to the first post.'),
('4', '6606932a09bb9', NULL, 'Just joined the community.'),
('5', '6606932a09bb9', '3', 'Reply to the reply.'),
('6', '6606932a09bb9', NULL, 'Another post from user1.'),
('7', '6606932a09bb9', '1', 'Second reply to the first post.');";
