CREATE USER 'acc_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON accounting.* TO 'acc_user'@'localhost';
FLUSH PRIVILEGES;
