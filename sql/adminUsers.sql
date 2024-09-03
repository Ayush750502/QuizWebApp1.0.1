

/*creating users table for quiz app*/
CREATE TABLE `quizapp`.`users` (`UserId` VARCHAR(15) NOT NULL , `Name` TEXT NOT NULL , `email` VARCHAR(30) NOT NULL , `Password` VARCHAR(15) NOT NULL ) ENGINE = InnoDB;

/*creating table for quizs */
CREATE TABLE `quiz` (
 `QuizId` varchar(15) NOT NULL,
 `Title` varchar(25) NOT NULL,
 `author` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

