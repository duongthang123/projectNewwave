-- tạo một sinh viên thuộc khoa B có điểm tất cả các môn học = 5 và tuổi = 50
INSERT INTO users (name, email, password) VALUES ('Duong Thang', 'thangg@gmail.com', 'password');
SET @user_id = LAST_INSERT_ID();
INSERT INTO students (user_id, student_code, status, gender, department_id) VALUES (@user_id, CONCAT(@user_id, YEAR(CURDATE)), 0, 0, 1);
SET @student_code = LAST_INSERT_ID();
INSERT INTO student_subject (student_id, subject_id, score)
    SELECT @student_id, id, 5
    FROM subjects;

-- cập nhật sinh viên có điểm trung bình thấp nhất thành 10
UPDATE student_subject 
JOIN (
    SELECT student_id
    FROM student_subject
    WHERE score IS NOT NULL
    GROUP BY student_id
    HAVING AVG(score) = (
        SELECT MIN(avg_score)
        FROM (
            SELECT AVG(score) as avg_score
            FROM student_subject
            WHERE score IS NOT NULL
            GROUP BY student_id
        ) AS avg_scores
    )
) AS result
ON student_subject.student_id = result.student_id
SET student_subject.score = 10

-- xóa tất cả thông tin của sinh viên tuổi >= 30; (students + users)
DELETE u, s
FROM students AS s
JOIN users AS u ON s.user_id = u.id
WHERE TIMESTAMPDIFF(YEAR, birthday, CURDATE()) >= 60;

-- tìm các sinh viên thuộc khoa A và có điểm trung bình > 5
SELECT s.id, u.name, AVG(ss.score) AS avg_score
FROM students s
    JOIN users u ON s.user_id = u.id
    JOIN departments d ON s.department_id = d.id
    JOIN student_subject ss ON s.id = ss.student_id
WHERE d.name = 'Kế toán'
GROUP BY s.id, u.name
HAVING AVG(ss.score) > 5;

-- tìm các sinh viên có SDT viettel + có tuổi từ 18 -> 25 và có điểm thi > 5
SELECT s.id, u.name, AVG(ss.score) AS avg_score
FROM students AS s
JOIN users AS u ON s.user_id = u.id
JOIN student_subject AS ss ON s.id = ss.student_id
WHERE phone REGEXP '^(098|097|096)[0-9]{7}$'
    AND TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 18 AND 25
GROUP BY s.id, u.name
HAVING AVG(ss.score) > 5

-- Giả sử A chưa học hết các môn, tìm các môn này
SELECT sb.id, sb.name
FROM subjects AS sb
WHERE sb.id NOT IN (
	SELECT student_subject.subject_id 
    FROM student_subject 
    WHERE student_id = 58642
);