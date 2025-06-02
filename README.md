# Musiknet API Service


## About the Project

**Musiknet** is a platform designed to connect emerging artists in the music industry. Its goal is to facilitate networking between musicians, composers, and producers, promoting collaborations that would otherwise be difficult to find.

The app works similarly to a dating app, initially presenting a stack of artist profile cards that could be relevant to the user. The user can then swipe right or left (like or dislike) to decide if they want to collaborate with that person. If both users swipe right (like), there's a **match**! The app will add that user to the chat list so they can start collaborating.

Each user provides a list of music genres they are interested in working on when registering, along with their role in the industry (producer, vocalist, composer...) and the role they are looking for. The app then displays a list of relevant users based on these parameters.

My role in this project was to create the **REST API service** that executes any operation performed in the app.

## Installation and launch
1. Clone the project and go to the root folder.
2. Copy the contents of .env.example into a .env file, and setup the variables according to your environment.
3. Launch the project: docker-compose up --build
4. To access the Swagger page, go to localhost:9000/docs.

---

## Tech Stack

- **Language:** PHP 8.3  
- **Framework:** Symfony 7.2  
- **Database:** MySQL  
- **ORM:** Doctrine  
- **Local Environment:** Docker with containers for Symfony, Nginx, and MySQL  
- **Dependency Manager:** Composer  
- **Architecture:** Hexagonal + CQRS (Command Query Responsibility Segregation)  
- **Documentation:** Nelmio  

---

## Authentication System

The API offers two authentication strategies:

- Google OAuth  
- Email & JWT Authentication  

### Email Authentication with JWT

For email authentication, I used a **JWT token system**. This provides a widely used, secure, and well-tested authentication mechanism.  

Symfony provides documentation and a dedicated bundle for JWT authentication: **LexikJWTAuthenticationBundle**.  

Additionally, I implemented a **Refresh Token** architecture to re-authenticate users when their access token expires. Both tokens have configurable TTLs, and when both expire, the user must log in again.

---

### Email Authentication Flow

#### a. Initial Login

- The process starts in `AuthController.php` with the `/auth/login` endpoint.  
- When the user sends their credentials (email/password), a `LoginUserCommand` is created.  
- The **LoginUser** application service validates the credentials and generates two tokens:  
  - **Access Token:** JWT for authentication.  
  - **Refresh Token:** To renew the access token.  

#### b. Request Validation

- The main authenticator is `EmailLoginAuthenticator.php`.  
- It intercepts all requests with an `Authorization` header.  
- It extracts the token from the Bearer header.  
- It validates the token using `TokenService`, a custom service based on `JWTTokenManagerInterface`.  
- If the token is valid, the corresponding user is loaded using the correct provider.  

#### c. Endpoint Protection

- Protected endpoints are configured in the `security.yaml` file.  
- The authenticated user can be accessed using the `#[CurrentUser]` attribute in controllers.  

#### d. Token Renewal

- The `/auth/refresh` endpoint in `AuthController` generates a new access token using the `RefreshToken`.  

#### e. Error Handling

- `InvalidJwtTokenException.php` handles invalid tokens.  
- Authentication errors are managed by the authenticator.  

---

## Architecture

The API follows **Hexagonal Architecture** principles along with **CQRS**.

Let's review how I implemented the flow of creating a Post.

### Request Flow

1. The controller receives the HTTP request.  
2. The controller creates a **Command** with the request data. This command is dispatched through the **CommandBus** to perform the operations.  
3. Symfony locates the corresponding **CommandHandler** and executes it. This handler has the **Application Service** injected via constructor, which manages the use case.  
4. The application service interacts with repositories and necessary services to perform the operation.  
5. The repositories injected into the use case are **Domain Services** (interfaces later implemented by concrete repositories). This makes it easy to implement different database strategies and decouples data input and output, which is handled in the **Infrastructure** layer.  
6. The application service returns data in case of a **Query** or performs the operation in case of a **Command**.

Work in progress...
