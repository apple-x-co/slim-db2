CREATE TABLE user_logs
(
    id         INTEGER AUTO_INCREMENT NOT NULL,
    user_id    INTEGER                NOT NULL COMMENT 'ユーザーID',
    text       TEXT                   NOT NULL COMMENT 'テキスト',
    created_at DATETIME               NOT NULL,
    updated_at DATETIME               NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_user_logs1 FOREIGN KEY (user_id) REFERENCES users (id)
);