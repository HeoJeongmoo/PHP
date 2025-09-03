-- 데이터베이스 생성
CREATE DATABASE IF NOT EXISTS seoul CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE seoul;

-- 예약 테이블 (reserve)
CREATE TABLE reserve (
    idx INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL COMMENT '식당명',
    pCnt INT NOT NULL COMMENT '인원수',
    menu VARCHAR(255) NOT NULL COMMENT '메뉴명',
    mCnt INT NOT NULL COMMENT '메뉴 수량',
    rDate DATETIME NOT NULL COMMENT '예약일시',
    bName VARCHAR(100) NOT NULL COMMENT '예약자명',
    bPhone VARCHAR(20) NOT NULL COMMENT '예약자 전화번호',
    bEmail VARCHAR(255) NOT NULL COMMENT '예약자 이메일',
    bPw VARCHAR(4) NOT NULL COMMENT '예약자 비밀번호',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email_pw (bEmail, bPw),
    INDEX idx_name_date (name, rDate)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='예약 정보';

-- 질문 테이블 (q)
CREATE TABLE q (
    idx INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL COMMENT '질문 제목',
    content TEXT NOT NULL COMMENT '질문 내용',
    rName VARCHAR(100) NOT NULL COMMENT '식당명',
    auth VARCHAR(255) NOT NULL COMMENT '작성자 인증정보 (email:pw)',
    attach VARCHAR(500) DEFAULT '' COMMENT '첨부파일',
    aIdx INT DEFAULT NULL COMMENT '채택된 답변 ID',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_rname (rName),
    INDEX idx_auth (auth)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='질문 게시판';

-- 답변 테이블 (a)
CREATE TABLE a (
    idx INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL COMMENT '답변 내용',
    qIdx INT NOT NULL COMMENT '질문 ID',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_qidx (qIdx),
    FOREIGN KEY (qIdx) REFERENCES q(idx) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='답변';

-- 외래키 추가 (채택된 답변)
ALTER TABLE q ADD CONSTRAINT fk_q_aidx FOREIGN KEY (aIdx) REFERENCES a(idx) ON DELETE SET NULL;

-- 샘플 데이터 삽입
-- 예약 샘플 데이터
INSERT INTO reserve (name, pCnt, menu, mCnt, rDate, bName, bPhone, bEmail, bPw) VALUES
('서동한식당', 4, '불고기정식', 4, '2024-09-15 12:00:00', '김철수', '010-1234-5678', 'kim@test.com', '1234'),
('서동전통찻집', 2, '전통차세트', 2, '2024-09-16 15:00:00', '이영희', '010-2345-6789', 'lee@test.com', '5678'),
('서동한우', 6, '한우특선', 6, '2024-09-17 18:00:00', '박민수', '010-3456-7890', 'park@test.com', '9012');

-- Q&A 샘플 데이터
INSERT INTO q (title, content, rName, auth, attach) VALUES
('예약 변경 문의', '예약한 시간을 변경하고 싶습니다.', '서동한식당', 'kim@test.com:1234', ''),
('메뉴 추천 부탁드립니다', '처음 방문하는데 추천 메뉴가 있나요?', '서동전통찻집', 'lee@test.com:5678', ''),
('주차 가능한가요?', '차량으로 방문 예정인데 주차공간이 있는지 궁금합니다.', '서동한우', 'park@test.com:9012', '');

-- 답변 샘플 데이터
INSERT INTO a (content, qIdx) VALUES
('예약 변경은 최소 1일 전에 연락주시면 가능합니다.', 1),
('저희 전통차세트와 한과세트를 추천드립니다.', 2),
('네, 매장 앞에 5대 정도 주차 가능한 공간이 있습니다.', 3),
('추가로 발레파킹 서비스도 제공하고 있습니다.', 3);

-- 채택된 답변 업데이트
UPDATE q SET aIdx = 1 WHERE idx = 1;
UPDATE q SET aIdx = 2 WHERE idx = 2;
UPDATE q SET aIdx = 3 WHERE idx = 3;