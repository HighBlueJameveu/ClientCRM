SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS crm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;;
USE crm_db;

CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    service_type ENUM('Кредит', 'Ипотека', 'Страхование жизни', 'КАСКО', 'Вклад') NOT NULL,
    status ENUM('Новый', 'В работе', 'Отказ', 'Сделка закрыта') DEFAULT 'Новый',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO clients (full_name, phone, email, service_type, status) VALUES 
('Иванов Иван Иванович', '+79991234567', 'ivanov@mail.ru', 'Кредит', 'В работе'),
('Петрова Анна Сергеевна', '+78887654321', 'petrova@yandex.ru', 'Страхование жизни', 'Новый'),
('Сидоров Петр Алексеевич', '+79111112233', 'sidorov@gmail.com', 'Ипотека', 'Сделка закрыта');