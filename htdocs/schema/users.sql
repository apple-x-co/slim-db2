CREATE TABLE users
(
    id         INTEGER AUTO_INCREMENT NOT NULL,
    name       VARCHAR(100)           NOT NULL COMMENT '名前',
    created_at DATETIME               NOT NULL,
    updated_at DATETIME               NOT NULL,
    PRIMARY KEY (id)
);