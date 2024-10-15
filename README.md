# 📦 User and Post Management API

This project is a RESTful API built with Laravel that provides functionalities for user management, post management, and tag management. It includes user authentication with OTP verification, scheduled jobs for data management, and a statistics endpoint to retrieve user and post counts. The API also features caching for enhanced performance.

## 🚀 Features

- **User Authentication**:
  - **Registration, Login, and logout**: Endpoints for user registration login, and logout, collecting name, phone number, and password.
  - **OTP Verification**: Enhanced security during registration with OTP verification.

- **Tag Management**:
  - **CRUD Operations**: Users can create, read, update, and delete tags.
  - **Unique Tag Names**: Tags are stored as unique names to avoid duplicates.

- **Post Management**:
  - **CRUD Operations**: Users can create, view, update, delete (soft delete), and restore their posts.
  - **Post Attributes**: Each post can have multiple tags, a title, body, cover image, and a pinned status.
  - **Authorization Policies**: Ensures that only the user who created a post can edit or delete it.

- **Request Validation**: 
  - Validates incoming requests using dedicated request classes for each feature.

- **Scheduled Jobs**:
  - **Daily Cleanup**: A job that permanently deletes softly deleted posts older than 30 days.
  - **Data Fetching**: A periodic job to fetch random user data from an external API.

- **Statistics Endpoint**:
  - An endpoint to retrieve the total number of users, total posts, and the count of users with zero posts.

- **Caching**: Results are cached to enhance performance and minimize database queries.

- **Traits**:
  - **ApiResponseTrait**: Used for returning consistent success or error responses throughout the application.
  - **ImageControlTrait**: Handles uploading or deleting images, used in the post controller.

- **API Resources**: Each model has its own API resource for standardized responses.

- **Eager Loading**: Prevents N+1 query problems when dealing with model relationships.

- **Observers**: Used for the User and Post models to update cached statistics whenever models are created, updated, or deleted.

## API Documentation
You can find the API documentation in the following file:

[API Documentation (Postman JSON)](api-documentation.json)

## 🗂️ Project Structure

```
📦 user_post_management_api
 ┣ 📂 app/Http/Controllers/Api/V1
 ┣ ┣ 📂 Auth
 ┃ ┃ ┣ 📄 LoginController.php                # Handles user login to the system
 ┃ ┃ ┣ 📄 RegisterController.php             # Handles user register to create an account
 ┃ ┃ ┣ 📄 LogoutController.php               # Handles user logout from the system
 ┃ ┃ ┗ 📄 VerificationController.php         # Handles verify the user account
 ┃ ┣ 📄 TagController.php                    # Handles tag management
 ┃ ┣ 📄 PostController.php                   # Handles post management
 ┃ ┗ 📄 StatsController.php                  # Controller for handling stats endpoint
 ┣ 📂 app/Http/Requests
 ┃ ┣ 📂 Auth
 ┃ ┃ ┣ 📄 LoginRequest.php                   # Request validation for login
 ┃ ┃ ┗ 📄 RegisterRequest.php                # Request validation for registration
 ┃ ┣ 📂 Tags
 ┃ ┃ ┣ 📄 StoreTagRequest.php                # Request validation for creating a new tag
 ┃ ┃ ┗ 📄 UpdateTagRequest.php               # Request validation for updating a tag
 ┃ ┣ 📂 Posts
 ┃ ┃ ┣ 📄 StorePostRequest.php               # Request validation for creating a new post
 ┃ ┃ ┗ 📄 UpdatePostRequest.php              # Request validation for updating a post
 ┣ 📂 app/Models
 ┃ ┣ 📄 User.php                             # User model with relationships
 ┃ ┣ 📄 Post.php                             # Post model with relationships
 ┃ ┣ 📄 Tag.php                              # Tag model with relationships
 ┣ 📂 app/Observers
 ┃ ┣ 📄 UserObserver.php                     # Observer for User model
 ┃ ┣ 📄 PostObserver.php                     # Observer for Post model
 ┣ 📂 app/Jobs
 ┃ ┣ 📄 DeleteSoftDeletedPosts.php           # Job for deleting old soft deleted posts
 ┃ ┗ 📄 GetRandomUserData.php                # Job for getting random user data
 ┣ 📂 app/Policies
 ┃ ┣ 📄 PostPolicy.php                       # Policy for post management
 ┣ 📂 database/migrations
 ┃ ┣ 📄 create_users_table.php               # Migration for users table
 ┃ ┣ 📄 create_posts_table.php               # Migration for posts table
 ┃ ┣ 📄 create_tags_table.php                # Migration for tags table
 ┃ ┣ 📄 create_post_tag_table.php            # Migration for post tag realationship table
 ┣ 📂 routes
 ┃ ┗ 📄 api.php                              # API routes definition
 ┃ ┗ 📄 console.php                          # Console routes definition for schedulling jobs
 ┣ 📄 .env                                   # Environment configuration
 ┗ 📄 api-documentation.json                 # Postman API Documentation
```

## 🛣️ API Routes

| Method  | Route                        | Description                                            | Auth Required |
|---------|------------------------------|--------------------------------------------------------|---------------|
| POST    | `/api/v1/register`           | Register a new user                                    |      No       |
| POST    | `/api/v1/login`              | Login an existing user                                 |      No       |
| POST    | `/api/v1/verify`             | Verify a user account                                  |      No       |
| POST    | `/api/v1/logout`             | Logout from the system and delete user tokens          |      Yes      |
|         |                              |                                                        |               |
| GET     | `/api/v1/tags`               | Get a list of all tags                                 |      Yes      |
| POST    | `/api/v1/tags`               | Create a new tag                                       |      Yes      |
| GET     | `/api/v1/tags/{id}`          | Get a single tag                                       |      Yes      |
| PUT     | `/api/v1/tags/{id}`          | Update a specific tag                                  |      Yes      |
| DELETE  | `/api/v1/tags/{id}`          | Delete a specific tag                                  |      Yes      |
|         |                              |                                                        |               |
| GET     | `/api/v1/posts`              | Get a list of all user's posts                         |      Yes      |
| GET     | `/api/v1/posts/deleted`      | Get a list of all user's deleted posts                 |      Yes      |
| POST    | `/api/v1/posts`              | Create a new post                                      |      Yes      |
| GET     | `/api/v1/posts/{id}`         | Get a single post                                      |      Yes      |
| PUT     | `/api/v1/posts/{id}`         | Update a specific post (only for the creator)          |      Yes      |
| DELETE  | `/api/v1/posts/{id}`         | Soft delete a specific post (only for the creator)     |      Yes      |
| POST    | `/api/v1/posts/{id}/restore` | Restore a softly deleted post (only for the creator)   |      Yes      |
|         |                              |                                                        |               |
| GET     | `/api/v1/stats`              | Retrieve statistics about users and posts              |      Yes      |

## 📝 Sample Code

### User Authentication

#### Register User
```php
// Auth/RegisterRequest.php
public function rules() {
    return [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|regex:/^01[1250][0-9]{8}$/|unique:users,phone',
        'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&#]/']
    ];
}

// Auth/AuthController.php
public function register(RegisterRequest $request) {
    // User registration logic
    ...
}
```

#### Login User
```php
// Auth/LoginRequest.php
public function rules() {
    return [
        'phone' => 'required|string',
        'password' => 'required|string',
    ];
}

// Auth/AuthController.php
public function login(LoginRequest $request) {
    // User login logic
    ...
}
```

### Tag Management

#### Create Tag
```php
// Tags/StoreTagRequest.php
public function rules() {
    return [
        'name' => 'required|string|unique:tags|max:255',
    ];
}

// Controllers/Api/V1/TagController.php
public function store(StoreTagRequest $request) {
    // Tag creation logic
    ...
}
```

### Post Management

#### Create Post
```php
// Posts/StorePostRequest.php
public function rules() {
    return [
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'is_pinned' => 'required|in:on,off',
        'tags' => 'required|array',
        'tags.*' => 'integer|exists:tags,id', 
        'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif'
    ];
}

// Controllers/Api/V1/PostController.php
public function store(StorePostRequest $request) {
    // Post creation logic, utilizing ImageControlTrait
    ...
}
```

### Authorization Policy

#### Policy for Post Management
```php
// PostPolicy.php
public function update(User $user, Post $post) {
    return $user->id === $post->user_id; // Only allow the post creator to update
}

public function delete(User $user, Post $post) {
    return $user->id === $post->user_id; // Only allow the post creator to delete
}
```

### Statistics Endpoint

#### Get Stats
```php
// Controllers/Api/V1/StatsController.php
public function getStats() {
    $stats = Cache::remember('user_post_stats', 60, function () {
        $totalUsers = User::count();
        $totalPosts = Post::count();        
        $usersWithZeroPosts = User::leftJoin('posts', 'users.id', '=', 'posts.user_id')
        ->whereNull('posts.id')
        ->count('users.id');

        return [
            'total_users' => $totalUsers,
            'total_posts' => $totalPosts,
            'users_with_zero_posts' => $usersWithZeroPosts,
        ];
    });

    return $this->success(['stats' => $stats], 'Statistics retrieved successfully');
}
```

## 🔧 Development Tools

- **Laravel**: PHP framework for building the API.
- **Laravel Sanctum**: Simple token-based authentication system.
- **Postman**: API development and testing tool.

## 📚 Getting Started

1. Clone the repository.
   ```bash
   git clone <repository-url>
   ```

2. Navigate to the project directory.
   ```bash
   cd blog_task
   ```

3. Install the dependencies.
   ```bash
   composer install
   ```

4. Set up the `.env` file.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Run the migrations.
   ```bash
   php artisan migrate
   ```


6. Start the development server.
   ```bash
   php artisan serve
   ```

## Contact 📧

For any questions or feedback, please reach out to me at [abdogoda0a@gmail.com].
