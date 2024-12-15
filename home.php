<?php
require_once("configuration/config.php");

// Fetch posts from the database
try {
    $query = $pdo->prepare("SELECT * FROM users_posts ORDER BY created_at DESC");
    $query->execute();
    $posts = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching posts: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>WeSpace - FYP</title>
  <!-- Open Sans Font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap"
    rel="stylesheet"
  />
  <!-- Poppins Font -->
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
    rel="stylesheet"
  />
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Body & Main Font */
    body {
      font-family: 'Open Sans', sans-serif;
      background: #f0f2f5;
      color: #333;
      line-height: 1.6;
    }

    /* Header Section */
    header {
      background: #4267b2;
      color: white;
      padding: 10px 20px;
      text-align: left;
      font-size: 20px;
      font-weight: 600;
    }

    .logo {
      font-weight: 600;
      display: inline-block;
      font-family: 'Poppins', sans-serif;
    }

    /* Main Section */
    main {
      padding: 10px 20px;
    }

    /* Post Section */
    .post-container {
      max-width: 600px;
      margin: 0 auto;
    }

    .post {
      background: white;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      padding: 15px;
      margin: 10px 0;
      transition: box-shadow 0.2s ease;
    }

    .post:hover {
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    /* Post Header */
    .post-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
      font-size: 14px;
      color: #555;
    }

    .user-profile {
      font-weight: 600;
    }

    .post-time {
      color: #777;
      font-size: 12px;
    }

    /* Post Content */
    .post-content {
      font-size: 15px;
      margin-bottom: 10px;
      color: #555;
    }

    /* Post Actions */
    .post-actions {
      display: flex;
      justify-content: space-around;
      margin-top: 10px;
      border-top: 1px solid #e0e0e0;
      padding: 5px 0;
    }

    .post-actions button {
      background: none;
      border: none;
      cursor: pointer;
      font-size: 14px;
      color: #4267b2;
      font-family: 'Open Sans', sans-serif;
      display: flex;
      align-items: center;
      gap: 5px;
      transition: color 0.2s ease;
    }

    .post-actions img {
      width: 20px;
      height: 20px;
      object-fit: contain;
    }

    .post-actions button:hover {
      color: #365899;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      main {
        padding: 5px 10px;
      }

      .post {
        padding: 10px;
      }

      .post-content {
        font-size: 14px;
      }

      header {
        font-size: 18px;
      }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="logo">WeSpace</div>
  </header>

  <!-- Main Section with Posts -->
  <main>
    <div class="post-container">
      <?php if (empty($posts)): ?>
        <!-- Message when no posts are available -->
        <div class="post">
          <div class="post-content" style="text-align: center; font-weight: 600; color: #555;">
            No posts available. Be the first to create one!
          </div>
        </div>
      <?php else: ?>
        <!-- Loop through posts and display -->
        <?php foreach ($posts as $post): ?>
          <div class="post">
            <div class="post-header">
              <div class="user-profile">👤 Anonymous User</div>
              <div class="post-time">
                <?php
                // Convert created_at to a human-readable format
                $createdAt = new DateTime($post['created_at']);
                echo $createdAt->format('F j, Y, g:i a');
                ?>
              </div>
            </div>
            <div class="post-content">
              <strong><?php echo htmlspecialchars($post['post_title']); ?></strong><br />
              <?php echo nl2br(htmlspecialchars($post['post_content'])); ?>
            </div>
            <div class="post-actions">
              <button class="like">
                <img src="assets/icons/like_icon.png" alt="Like" />
                Like
              </button>
              <button class="comment">
                <img src="assets/icons/comment_icon.png" alt="Comment" />
                Comment
              </button>
              <button class="share">
                <img src="assets/icons/share_icon.png" alt="Share" />
                Share
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>
</body>
</html>
