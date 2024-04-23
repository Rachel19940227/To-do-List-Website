-- 创建数据库如果不存在
CREATE DATABASE IF NOT EXISTS assignment2;

-- 给 appuser 用户授予 assignment2 数据库的所有权限
GRANT ALL PRIVILEGES ON assignment2.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

-- 使用 assignment2 数据库
USE assignment2;

-- 创建 users 表
CREATE TABLE IF NOT EXISTS users (
    userID INT AUTO_INCREMENT PRIMARY KEY, -- 用户ID，自增
    username VARCHAR(50) NOT NULL, -- 用户名，不为空
    password VARCHAR(50) NOT NULL -- 密码，不为空
);

-- 创建 tasks 表
CREATE TABLE IF NOT EXISTS tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY, -- 任务ID，自增
    task_name VARCHAR(255) NOT NULL, -- 任务名称，不为空
    task_info TEXT, -- 任务信息
    priority_level ENUM('Low', 'Medium', 'High') NOT NULL, -- 优先级，枚举类型
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP, -- 创建时间，默认当前时间
    complete BOOLEAN DEFAULT FALSE, -- 完成状态，默认为假
    user_id INT -- 用户ID
);

-- 添加 tasks 表的外键约束，关联 users 表的 userID 字段
ALTER TABLE tasks
ADD FOREIGN KEY (user_id) REFERENCES users(userID)
ON DELETE SET NULL -- 删除用户时设置为 NULL
ON UPDATE CASCADE; -- 更新用户ID时级联更新

-- 向 users 表中插入三个用户
INSERT INTO users (username, password) VALUES ('User 1', 'password1');
INSERT INTO users (username, password) VALUES ('User 2', 'password2');
INSERT INTO users (username, password) VALUES ('User 3', 'password3');

-- 向 tasks 表中插入示例数据
INSERT INTO tasks (task_name, task_info, priority_level, user_id, complete)
VALUES 
    ('Task 1', 'Task 1 info', 'Low', 1, FALSE),
    ('Task 2', 'Task 2 info', 'Medium', 2, TRUE),
    ('Task 3', 'Task 3 info', 'High', 3, FALSE);
