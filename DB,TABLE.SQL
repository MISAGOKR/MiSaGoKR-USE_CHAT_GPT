-- 데이터베이스 생성
CREATE DATABASE community_db;

-- 사용할 데이터베이스 선택
USE community_db;

-- 회원 테이블 생성
CREATE TABLE members (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL,
  agreement TINYINT(1) NOT NULL DEFAULT 0,
  is_verified TINYINT(1) NOT NULL DEFAULT 0
);

-- 게시판 테이블 생성
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  author_id INT NOT NULL,
  title VARCHAR(100) NOT NULL,
  category VARCHAR(50) NOT NULL,
  content TEXT NOT NULL,
  file_path VARCHAR(200),
  video_path VARCHAR(200),
  image_path VARCHAR(200),
  created_at DATETIME NOT NULL,
  FOREIGN KEY (author_id) REFERENCES members(id)
);

-- 댓글 테이블 생성
CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  author_id INT NOT NULL,
  content TEXT NOT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (post_id) REFERENCES posts(id),
  FOREIGN KEY (author_id) REFERENCES members(id)
);

-- 카테고리 테이블 생성
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);

-- 파일 테이블 생성
CREATE TABLE files (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  file_path VARCHAR(200) NOT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (post_id) REFERENCES posts(id)
);

-- 동영상 테이블 생성
CREATE TABLE videos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  video_path VARCHAR(200) NOT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (post_id) REFERENCES posts(id)
);

-- 사진 테이블 생성
CREATE TABLE images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  image_path VARCHAR(200) NOT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (post_id) REFERENCES posts(id)
);

-- 관리자 테이블 생성
CREATE TABLE administrators (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL
);

-- 회원가입 인증 테이블 생성
CREATE TABLE registration_tokens (
  token VARCHAR(100) PRIMARY KEY,
  email VARCHAR(50) NOT NULL,
  created_at DATETIME NOT NULL
);

-- 회원 정보 찾기 테이블 생성
CREATE TABLE password_reset_tokens (
  token VARCHAR(100) PRIMARY KEY,
  email VARCHAR(50) NOT NULL,
  created_at DATETIME NOT NULL
);

-- 푸시 알림 테이블 생성
CREATE TABLE push_notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  member_id INT NOT NULL,
  message VARCHAR(200) NOT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (member_id) REFERENCES members(id)
);

-- 채팅 테이블 생성
CREATE TABLE chats (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_id INT NOT NULL,
  receiver_id INT NOT NULL,
  message TEXT NOT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (sender_id) REFERENCES members(id),
  FOREIGN KEY (receiver_id) REFERENCES members(id)
);
