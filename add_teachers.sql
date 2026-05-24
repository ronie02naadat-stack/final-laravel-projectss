-- Insert new teachers
INSERT INTO users (name, email, user_type, password, created_at, updated_at) VALUES
('Dr. Maria Santos', 'maria.santos@school.com', 'teacher', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5EjkzProjection', NOW(), NOW()),
('Prof. James Mitchell', 'james.mitchell@school.com', 'teacher', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5EjkzProjection', NOW(), NOW()),
('Dr. Emily Chen', 'emily.chen@school.com', 'teacher', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5EjkzProjection', NOW(), NOW()),
('Prof. Robert Johnson', 'robert.johnson@school.com', 'teacher', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5EjkzProjection', NOW(), NOW()),
('Dr. Sophia Williams', 'sophia.williams@school.com', 'teacher', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5EjkzProjection', NOW(), NOW()),
('Prof. David Martinez', 'david.martinez@school.com', 'teacher', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5EjkzProjection', NOW(), NOW()),
('Dr. Lisa Anderson', 'lisa.anderson@school.com', 'teacher', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5EjkzProjection', NOW(), NOW());

-- Assign courses to teachers
UPDATE courses SET teacher_id = 10 WHERE id IN (1, 2, 3);
UPDATE courses SET teacher_id = 11 WHERE id IN (4, 5, 6);
UPDATE courses SET teacher_id = 12 WHERE id IN (7, 8, 9);
UPDATE courses SET teacher_id = 13 WHERE id IN (10, 11, 12);
UPDATE courses SET teacher_id = 14 WHERE id IN (13, 14, 15);
UPDATE courses SET teacher_id = 15 WHERE id IN (16, 17, 18);
UPDATE courses SET teacher_id = 16 WHERE id IN (19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36);
