-- Create or Use the Database
CREATE DATABASE IF NOT EXISTS DEVS_Movie_Share;
USE DEVS_Movie_Share;

-- Create the Subscription Table
CREATE TABLE subscriptions (
    subscription_id INT AUTO_INCREMENT PRIMARY KEY,
    subscription_type ENUM('Monthly', 'Yearly') NOT NULL,
    subscription_start_date DATE NOT NULL,
    subscription_end_date DATE NOT NULL,
    payment_status ENUM('Paid', 'Pending') NOT NULL
);

-- Create the Customer Table
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    subscription_id INT,
    is_adult BOOLEAN NOT NULL,
    account_created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subscription_id) REFERENCES subscriptions(subscription_id) ON DELETE SET NULL
);

-- Create the Movies Table
CREATE TABLE movies (
    movie_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    duration TIME NOT NULL,
    director VARCHAR(100),
    producer VARCHAR(100),
    language VARCHAR(50),
    release_date DATE NOT NULL,
    rating DECIMAL(2, 1), -- e.g., 4.5
    category ENUM('Adult', 'Kids') NOT NULL
);

-- Create the Adult Table
CREATE TABLE adult_movies (
    adult_movie_id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    genre VARCHAR(100) NOT NULL,
    rating DECIMAL(2, 1),
    release_date DATE NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);

-- Create the Cartoon Table
CREATE TABLE cartoons (
    cartoon_movie_id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    age_group VARCHAR(50) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    release_date DATE NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);

-- Create the Kids Table
CREATE TABLE kids_movies (
    kids_movie_id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    age_group VARCHAR(50) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    release_date DATE NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);

-- Create the Notification Table
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    message TEXT NOT NULL,
    sent_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE
);

-- Create the Latest Alerts Table (New Movie Alerts)
CREATE TABLE latest_alerts (
    alert_id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    notification_message TEXT NOT NULL,
    notification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);

-- Create the Watch List Table
CREATE TABLE watchlist (
    watchlist_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    movie_id INT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);

-- Create the Wishlist Table
CREATE TABLE wishlist (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    movie_id INT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE
);
