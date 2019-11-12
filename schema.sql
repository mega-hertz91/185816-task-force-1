CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE `city`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name`       varchar(50),
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW()
);

CREATE TABLE `role`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `role`       varchar(255) UNIQUE,
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW()
);

CREATE TABLE `user_status`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `status`       varchar(255) UNIQUE,
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW()
);

CREATE TABLE `user`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `full_name`  varchar(255) NOT NULL,
    `email`      varchar(255) UNIQUE,
    `role_id`    int,
    `city_id`    int,
    `user_status_id` int,
    `date_birth` timestamp NOT NULL,
    `about`      text,
    `password`   varchar(255) NOT NULL,
    `tel`        int(15),
    `skype`      varchar(255),
    `messenger`  varchar(255),
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW(),
    FOREIGN KEY (role_id) REFERENCES role(id),
    FOREIGN KEY (city_id) REFERENCES city(id),
    FOREIGN KEY (user_status_id) REFERENCES user_status(id)
);

CREATE TABLE `message`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `sender`      int,
    `recipient`   int,
    `message`     text,
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW(),
    FOREIGN KEY (sender) REFERENCES user(id),
    FOREIGN KEY (recipient) REFERENCES user(id)
);

CREATE TABLE `category`
(
    `id`            int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `category_name` varchar(255),
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW()
);

CREATE TABLE `comment`
(
    `id`          int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `user_id`    int,
    `description` text,
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES user(id)
);

CREATE TABLE `status`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name`       varchar(100),
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW()
);

CREATE TABLE `response`
(
    `id`         int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `user_id`   int,
    `amount`    int,
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES user(id)
);


CREATE TABLE `task`
(
    `id`            int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `category_id` int,
    `title`         varchar(255) NOT NULL,
    `description`   text,
    `city_id`     int,
    `user_id`      int,
    `executor_id`   int,
    `comment_id`   int,
    `response_id`  int,
    `amount`       int,
    `rating`        int,
    `status_id`    int,
    `created_at` timestamp DEFAULT NOW(),
    `updated_at` timestamp DEFAULT NOW(),
    FOREIGN KEY (category_id) REFERENCES category(id),
    FOREIGN KEY (city_id) REFERENCES city(id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (comment_id) REFERENCES comment(id),
    FOREIGN KEY (response_id) REFERENCES response(id),
    FOREIGN KEY (executor_id) REFERENCES user(id)
);

/* https://dbdiagram.io/d/5dbc1917edf08a25543d6630 */
