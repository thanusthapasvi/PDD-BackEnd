-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2026 at 05:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `interview_assist`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `hiring_roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`roles`)),
  `locations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`locations`)),
  `exam_pattern` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`exam_pattern`)),
  `info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`info`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `hiring_roles`, `roles`, `locations`, `exam_pattern`, `info`) VALUES
(1, 'Cognizant', '[\"GenC\",\"GenC Elevate\",\"GenC Next\"]', '[\"SDE\"]', '[\"Chennai\",\"Bangalore\",\"Hyderabad\",\"Pune\",\"Kolkata\",\"Noida\",\"Coimbatore\",\"Mumbai\",\"Kochi\",\"Indore\",\"Mangaluru\",\"Bhubaneswar\"]', '[\r\n    {\"round\":\"Communication Assessment\",\"questions\": \"60 MCQs\",\"duration\":60},\r\n    {\"round\":\"Quants + Game Based Assessment\",\"questions\": \"80 MCQs\",\"duration\":80},\r\n    {\"round\":\"Technical Assessment\",\"questions\": \"2 Coding, 2 SQL, 1 Web, 10 MCQs\",\"duration\":120}\r\n  ]', '{\r\n    \"about\":\"Cognizant is a multinational IT services and consulting company.\",\r\n    \"min_package\":4,\r\n    \"max_package\":6.75,\r\n    \"website\":\"https://www.cognizant.com\",\r\n    \"ceo\":\"Ravi Kumar S\",\r\n    \"important\":\"Known for digital transformation, cloud, AI, and IT services.\"\r\n  }'),
(2, 'Blackstraw', '[\"Data Engineer\",\"Junior Data Scientist\",\"AI/ML Engineer\"]', '[\"Data Analyst\",\"ML Engineer\",\"Data Engineer\"]', '[\"Chennai\",\"Bangalore\",\"Hyderabad\"]', '[\r\n    {\"round\":\"Aptitude Test\",\"questions\":\"20 MCQs\",\"duration\":60},\r\n    {\"round\":\"Technical Test\",\"questions\":\"10 MCQs, 2 Coding\",\"duration\":90}\r\n  ]', '{\r\n    \"about\":\"Blackstraw is a data and AI consulting company based in India.\",\r\n    \"min_package\":6,\r\n    \"max_package\":8,\r\n    \"website\":\"https://www.blackstraw.ai\",\r\n    \"ceo\":\"Atul Arya\",\r\n    \"important\":\"Specializes in data engineering, analytics, and AI solutions.\"\r\n  }'),
(3, 'TCS', '[\"Ninja\",\"Digital\",\"Prime\"]', '[\"SDE\",\"System Engineer\"]', '[\"Chennai\",\"Bangalore\",\"Hyderabad\",\"Pune\",\"Kolkata\",\"Mumbai\",\"Noida\"]', '[\r\n    {\"round\":\"Verbal Ability\",\"questions\":\"25 MCQs\",\"duration\":25},\r\n    {\"round\":\"Reasoning Ability\",\"questions\":\"20 MCQs\",\"duration\":25},\r\n    {\"round\":\"Numerical Ability\",\"questions\":\"20 MCQs\",\"duration\":25},\r\n    {\"round\":\"Advanced Aptitude\",\"questions\":\"15 MCQs\",\"duration\":25},\r\n    {\"round\":\"Advanced Coding\",\"questions\":\"2 Coding\",\"duration\":90}\r\n  ]', '{\r\n    \"about\":\"Tata Consultancy Services is one of the largest IT services companies in the world.\",\r\n    \"min_package\":3.5,\r\n    \"max_package\":9,\r\n    \"website\":\"https://www.tcs.com\",\r\n    \"ceo\":\"K Krithivasan\",\r\n    \"important\":\"TCS NQT is the main hiring exam for freshers.\"\r\n  }'),
(4, 'Infosys', '[\"Systems Engineer\",\"Digital Specialist\",\"Specialist Programmer\"]', '[\"SDE\",\"System Engineer\"]', '[\"Bangalore\",\"Hyderabad\",\"Pune\",\"Chennai\",\"Mysore\",\"Noida\"]', '[\r\n    {\"round\":\"Aptitude Test\",\"questions\":\"40 MCQs\",\"duration\":120},\r\n    {\"round\":\"Coding Test\",\"questions\":\"2 Coding\",\"duration\":60}\r\n  ]', '{\r\n    \"about\":\"Infosys is a global leader in IT services and consulting.\",\r\n    \"min_package\":3.5,\r\n    \"max_package\":7,\r\n    \"website\":\"https://www.infosys.com\",\r\n    \"ceo\":\"Salil Parekh\",\r\n    \"important\":\"Infosys conducts InfyTQ and HackWithInfy for hiring.\"\r\n  }'),
(6, 'HCL', '[\"GET\",\"AMP\"]', '[\"SDE\",\"System Engineer\"]', '[\"Noida\",\"Chennai\",\"Bangalore\",\"Hyderabad\",\"Pune\"]', '[\r\n    {\"round\":\"Aptitude Test\",\"questions\":\"25 MCQs\",\"duration\":60},\r\n    {\"round\":\"Technical Test\",\"questions\":\"20 MCQs\",\"duration\":60}\r\n  ]', '{\r\n    \"about\":\"HCL is a global IT services and consulting company.\",\r\n    \"min_package\":3.5,\r\n    \"max_package\":7,\r\n    \"website\":\"https://www.hcltech.com\",\r\n    \"ceo\":\"C Vijayakumar\",\r\n    \"important\":\"HCL recruits through campus drives and HCLTechBee.\"\r\n  }'),
(7, 'Accenture', '[\"SASA\",\"ASE\"]', '[\"SDE\",\"Associate Software Engineer\"]', '[\"Bangalore\",\"Hyderabad\",\"Pune\",\"Chennai\",\"Mumbai\",\"Noida\",\"Kolkata\"]', '[\r\n    {\"round\":\"Cognitive Assessment\",\"questions\":\"50 MCQs\",\"duration\":90},\r\n    {\"round\":\"Coding Assessment\",\"questions\":\"2 Coding\",\"duration\":60}\r\n  ]', '{\r\n    \"about\":\"Accenture is a global professional services company specializing in digital and cloud.\",\r\n    \"min_package\":4.5,\r\n    \"max_package\":11,\r\n    \"website\":\"https://www.accenture.com\",\r\n    \"ceo\":\"Julie Sweet\",\r\n    \"important\":\"Accenture hires through Cognitive and Coding assessments.\"\r\n  }'),
(8, 'Hexaware', '[\"GET\",\"PGET\"]', '[\"SDE\",\"Graduate Engineer Trainee\"]', '[\"Chennai\",\"Bangalore\",\"Pune\",\"Mumbai\",\"Noida\"]', '[\r\n    {\"round\":\"Aptitude + verbal\",\"questions\":\"60 MCQs\",\"duration\":60},\r\n    {\"round\":\"Domain based\",\"questions\":\"30 MCQs\",\"duration\":30},\r\n    {\"round\":\"Coding Test\",\"questions\":\"2 Coding\",\"duration\":60}\r\n  ]', '{\r\n    \"about\":\"Hexaware is a global IT services company focusing on automation and digital transformation.\",\r\n    \"min_package\":4,\r\n    \"max_package\":6.5,\r\n    \"website\":\"https://www.hexaware.com\",\r\n    \"ceo\":\"R Srikrishna\",\r\n    \"important\":\"Hexaware recruits through campus drives and AMCAT tests.\"\r\n  }'),
(11, 'Wipro', '[\"Elite NTH\",\"Turbo\",\"WILP\"]', '[\"Software Engineer\",\"DevOps Engineer\"]', '[\"Bengaluru\",\"Hyderabad\",\"Chennai\",\"Greater Noida\",\"Pune\",\"Coimbatore\"]', '[{\"round\":\"Aptitude & Reasoning\",\"questions\":\"40\",\"duration\":40},{\"round\":\"Communication\",\"questions\":\"1\",\"duration\":20},{\"round\":\"Technical\",\"questions\":\"2\",\"duration\":60}]', '{\"about\":\"Wipro is a leading global information technology, consulting, and business process services company\",\"min_package\":3.5,\"max_package\":7,\"website\":\"https://www.wipro.com\",\"ceo\":\"Thierry Delaporte\",\"important\":\"Most fresher roles involve a 1 year bond\"}');

-- --------------------------------------------------------

--
-- Table structure for table `company_faqs`
--

CREATE TABLE `company_faqs` (
  `company_id` int(11) NOT NULL,
  `faq_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_faqs`
--

INSERT INTO `company_faqs` (`company_id`, `faq_id`) VALUES
(1, 1),
(1, 2),
(1, 8),
(1, 10),
(2, 6),
(2, 9),
(3, 1),
(3, 4),
(4, 4),
(7, 2),
(8, 6);

-- --------------------------------------------------------

--
-- Table structure for table `experience_bookmarks`
--

CREATE TABLE `experience_bookmarks` (
  `user_id` int(11) NOT NULL,
  `experience_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience_bookmarks`
--

INSERT INTO `experience_bookmarks` (`user_id`, `experience_id`) VALUES
(4, 1),
(4, 2),
(5, 1),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `is_code` tinyint(1) DEFAULT NULL,
  `cpp` text DEFAULT NULL,
  `python` text DEFAULT NULL,
  `java` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `is_code`, `cpp`, `python`, `java`) VALUES
(1, 'What is the difference between Abstract Class and Interface in Java?', 'Abstract class can have abstract and non-abstract methods, serving as a partial template that allows you to provide a common base with shared logic and internal state (fields). In contrast, an interface is primarily a contract that defines behavior, and while it can include default or static methods, it cannot maintain instance state through variables. A key structural difference is that a Java class is limited to extending only one abstract class, whereas it can implement multiple interfaces, offering greater architectural flexibility. Essentially, use an abstract class when you want to capture \"what an object is\" and an interface to define \"what an object can do.', NULL, NULL, NULL, NULL),
(2, 'What is normalization in DBMS?', 'Normalization is the process of organizing data in a database to reduce data redundancy and improve data integrity by ensuring that every field and table has a single, logical purpose. It involves decomposing large, complex tables into smaller, manageable ones and defining relationships between them using primary and foreign keys. This systematic approach follows a series of rules called Normal Forms (such as 1NF, 2NF, and 3NF), which help eliminate update, insertion, and deletion anomalies. Ultimately, normalization creates a more efficient storage structure where information is stored in only one place, making the database easier to maintain and scale.', NULL, NULL, NULL, NULL),
(3, 'What is the difference between GET and POST?', 'GET sends data in URL parameters, making the data visible to everyone in the browser\'s address bar and limiting the amount of information you can send to a few thousand characters. In contrast, POST sends data within the HTTP message body, which is more secure for sensitive information like passwords and allows for much larger payloads, including file uploads. Because GET requests are intended for retrieving data, they are idempotent (multiple identical requests have the same effect as one) and can be bookmarked or cached by browsers. POST requests, however, are typically used to create or update resources on the server; they are not cached and will often trigger a \"confirm resubmission\" warning if you refresh the page.', NULL, NULL, NULL, NULL),
(4, 'Difference between Method Overloading and Overriding?', 'Method overloading occurs within the same class when methods share the same name but have different parameter lists (type, number, or order). In contrast, method overriding happens when a subclass provides a specific implementation for a method already defined in its parent class using the exact same signature. Overloading is a compile-time (static) polymorphism, while overriding is a runtime (dynamic) polymorphism.', NULL, NULL, NULL, NULL),
(5, 'What is OOPS?', 'OOPS stands for Object Oriented Programming System, a programming paradigm based on the concept of \"objects,\" which can contain data in the form of fields (attributes) and code in the form of procedures (methods). Instead of focusing on logic and functions, OOPS focuses on the data that developers want to manipulate. This approach is designed to make software more modular, reusable, and easier to maintain by structuring programs around real-world entities. The Four Pillars of OOPS are Encapsulation, Abstraction, Inheritance, Polymorphism', NULL, NULL, NULL, NULL),
(6, 'What is REST API?', 'REST is an architectural style for designing networked applications that uses the HTTP protocol to enable communication between a client and a server. It is based on a stateless, client-server model where every resource (such as a user, an image, or a piece of data) is identified by a unique URI (Uniform Resource Identifier). Instead of complex protocols, REST relies on standard HTTP methods like GET, POST, PUT, and DELETE to perform operations on these resources, typically exchanging data in lightweight formats like JSON or XML.', NULL, NULL, NULL, NULL),
(7, 'Difference between Array and ArrayList?', 'Array has fixed size, meaning once it is initialized, its length cannot be changed, whereas an ArrayList is a dynamic data structure that automatically grows or shrinks as elements are added or removed. In an array, you must specify the size at the time of creation, which can lead to memory inefficiency if the size is overestimated or errors if it is underestimated. In contrast, an ArrayList is part of the Java Collections Framework and provides built-in methods for common operations like searching, sorting, and inserting elements. While arrays can store both primitive data types (like int, char) and objects, ArrayLists can only store objects, requiring primitives to be wrapped in their corresponding wrapper classes (like Integer).', NULL, NULL, NULL, NULL),
(8, 'Reverse a string without using built-in functions.', 'Iterate from the end of the string and build a new string by appending characters one by one.', 1, '#include <iostream>\r\n#include <string>\r\nusing namespace std;\r\n\r\nint main() {\r\n    string str = \"hello\";\r\n    string reversed = \"\";\r\n\r\n    for (int i = str.length() - 1; i >= 0; i--) {\r\n        reversed += str[i];\r\n    }\r\n\r\n    cout << reversed;\r\n    return 0;\r\n}', 's = \"hello\"\r\nreversed_string = \"\"\r\n\r\ni = len(s) - 1\r\n\r\nwhile i >= 0:\r\n    reversed_string += s[i]\r\n    i -= 1\r\n\r\nprint(reversed_string)', 'public class ReverseString {\r\n    public static void main(String[] args) {\r\n        String str = \"hello\";\r\n        String reversed = \"\";\r\n\r\n        for(int i = str.length() - 1; i >= 0; i--) {\r\n            reversed += str.charAt(i);\r\n        }\r\n\r\n        System.out.println(reversed);\r\n    }\r\n}'),
(9, 'Write a program to check whether a number is prime.', 'A prime number has exactly two factors: 1 and itself. Check divisibility from 2 up to the square root of the number.', 1, '#include <iostream>\r\nusing namespace std;\r\n\r\nint main() {\r\n    int num = 29;\r\n    bool isPrime = true;\r\n\r\n    for(int i = 2; i * i <= num; i++) {\r\n        if(num % i == 0) {\r\n            isPrime = false;\r\n            break;\r\n        }\r\n    }\r\n\r\n    if(isPrime && num > 1)\r\n        cout << \"Prime\";\r\n    else\r\n        cout << \"Not Prime\";\r\n\r\n    return 0;\r\n}', 'num = 29\r\nis_prime = True\r\n\r\ni = 2\r\n\r\nwhile i * i <= num:\r\n    if num % i == 0:\r\n        is_prime = False\r\n        break\r\n    i += 1\r\n\r\nif is_prime and num > 1:\r\n    print(\"Prime\")\r\nelse:\r\n    print(\"Not Prime\")', 'public class PrimeCheck {\r\n    public static void main(String[] args) {\r\n        int num = 29;\r\n        boolean isPrime = true;\r\n\r\n        for(int i = 2; i * i <= num; i++) {\r\n            if(num % i == 0) {\r\n                isPrime = false;\r\n                break;\r\n            }\r\n        }\r\n\r\n        if(isPrime && num > 1)\r\n            System.out.println(\"Prime\");\r\n        else\r\n            System.out.println(\"Not Prime\");\r\n    }\r\n}'),
(10, 'Print duplicate elements in an array', 'Traverse the array using two loops and compare each element with the remaining elements. If a match is found, print the element.', 1, '#include <iostream>\r\nusing namespace std;\r\n\r\nint main() {\r\n    int arr[] = {1, 2, 3, 2, 4, 3};\r\n    int n = 6;\r\n\r\n    for(int i = 0; i < n; i++) {\r\n        for(int j = i + 1; j < n; j++) {\r\n            if(arr[i] == arr[j]) {\r\n                cout << arr[i] << \" \";\r\n                break;\r\n            }\r\n        }\r\n    }\r\n    return 0;\r\n}', 'arr = [1,2,3,2,4,3]\r\nn = len(arr)\r\n\r\nfor i in range(n):\r\n    for j in range(i+1,n):\r\n        if arr[i] == arr[j]:\r\n            print(arr[i])\r\n            break', 'public class PrintDuplicates {\r\n    public static void main(String[] args) {\r\n        int[] arr = {1,2,3,2,4,3};\r\n        int n = arr.length;\r\n\r\n        for(int i=0;i<n;i++){\r\n            for(int j=i+1;j<n;j++){\r\n                if(arr[i]==arr[j]){\r\n                    System.out.print(arr[i] + \" \");\r\n                    break;\r\n                }\r\n            }\r\n        }\r\n    }\r\n}'),
(11, 'Remove duplicate elements from an array.', 'Compare each element with previous elements and store only unique values in a new array.', 1, '#include <iostream>\r\nusing namespace std;\r\n\r\nint main() {\r\n    int arr[] = {1,2,3,2,4,3};\r\n    int n = 6;\r\n\r\n    for(int i = 0; i < n; i++) {\r\n        bool duplicate = false;\r\n\r\n        for(int j = 0; j < i; j++) {\r\n            if(arr[i] == arr[j]) {\r\n                duplicate = true;\r\n                break;\r\n            }\r\n        }\r\n\r\n        if(!duplicate) {\r\n            cout << arr[i] << \" \";\r\n        }\r\n    }\r\n\r\n    return 0;\r\n}', 'arr = [1,2,3,2,4,3]\r\nn = len(arr)\r\n\r\nfor i in range(n):\r\n    duplicate = False\r\n    \r\n    for j in range(i):\r\n        if arr[i] == arr[j]:\r\n            duplicate = True\r\n            break\r\n    \r\n    if not duplicate:\r\n        print(arr[i])', 'public class RemoveDuplicates {\r\n    public static void main(String[] args) {\r\n        int[] arr = {1,2,3,2,4,3};\r\n        int n = arr.length;\r\n\r\n        for(int i=0;i<n;i++){\r\n            boolean duplicate = false;\r\n\r\n            for(int j=0;j<i;j++){\r\n                if(arr[i]==arr[j]){\r\n                    duplicate = true;\r\n                    break;\r\n                }\r\n            }\r\n\r\n            if(!duplicate){\r\n                System.out.print(arr[i] + \" \");\r\n            }\r\n        }\r\n    }\r\n}'),
(12, 'Give an example of polymorphism.', 'Polymorphism allows methods to perform different behaviors based on parameters. One common example is method overloading.', 1, '#include <iostream>\r\nusing namespace std;\r\n\r\nclass Math {\r\npublic:\r\n    int add(int a, int b) {\r\n        return a + b;\r\n    }\r\n\r\n    int add(int a, int b, int c) {\r\n        return a + b + c;\r\n    }\r\n};\r\n\r\nint main() {\r\n    Math m;\r\n    cout << m.add(2,3) << endl;\r\n    cout << m.add(2,3,4);\r\n}', 'class Math:\r\n\r\n    def add(self, a, b, c=None):\r\n        if c is None:\r\n            return a + b\r\n        else:\r\n            return a + b + c\r\n\r\n\r\nm = Math()\r\nprint(m.add(2,3))\r\nprint(m.add(2,3,4))', 'class Math {\r\n\r\n    int add(int a, int b){\r\n        return a + b;\r\n    }\r\n\r\n    int add(int a, int b, int c){\r\n        return a + b + c;\r\n    }\r\n\r\n    public static void main(String[] args){\r\n        Math m = new Math();\r\n\r\n        System.out.println(m.add(2,3));\r\n        System.out.println(m.add(2,3,4));\r\n    }\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `interview_experiences`
--

CREATE TABLE `interview_experiences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `overview` text NOT NULL,
  `questions_asked` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`questions_asked`)),
  `preparation_tips` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`preparation_tips`)),
  `advice` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `hired_role` varchar(10) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `difficulty` enum('easy','easy-medium','medium','medium-hard','hard') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interview_experiences`
--

INSERT INTO `interview_experiences` (`id`, `user_id`, `company_id`, `title`, `overview`, `questions_asked`, `preparation_tips`, `advice`, `hired_role`, `role`, `difficulty`, `created_at`) VALUES
(1, 1, 1, 'Don\'t panic, Interviewer is friendly', 'The interview process has following rounds: online assessment, technical and HR round. Interview was taken through superset portal. Overall experience was smooth and interviewers were friendly.', '[\"What are 4 pillars of OOP ?\",\"Explain normalization in DBMS\",\"Write a SQL query for selecting only first 3 letters of name from a table\",\"Write a SQL query to select names that start with letter s\",\"Write java program to only print duplicates from a array\"]', '[\"Practice basic coding problems\",\"Revise DBMS and SQL queries\",\"Prepare core JavaScript concepts\",\"Work on communication skills\"]', '[\"Stay calm and confident\",\"Explain your logic clearly\",\"Don\\u2019t rush while coding\",\"Prepare to explain about your projects\"]', 'GenC', 'SDE', 'easy-medium', '2026-02-12 15:58:22'),
(2, 1, 3, 'TCS NQT to Interview', 'Friendly process, but TCS is prefers Ai and python domain people, I got selected for prime interview but go Ninja role', '[\"Explain OOP\",\"Explain types of cloud services\",\"Program - in a square matrix find largest number and return no. of swaps needed to move that number to center\"]', '[\"Prepare Cloud computing questions\",\"Prepare Artificial intelligence questions\",\"Be ready to explain anything in resume\",\"Ready to explain projects in resume\"]', '[\"Don\'t add things you are not clear in resume\",\"Study on cloud and AI questions\",\"all 3 Interviewers are friendly\"]', 'Ninja', 'SDE', 'medium', '2026-02-22 11:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `signup_otps`
--

CREATE TABLE `signup_otps` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `otp_expires_at` datetime NOT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('fresher','alumni','admin') NOT NULL DEFAULT 'fresher',
  `current_year` tinyint(4) NOT NULL DEFAULT 0,
  `profile_pic` tinyint(4) DEFAULT 0,
  `email_verified` tinyint(1) DEFAULT 0,
  `email_otp` varchar(255) DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `current_year`, `profile_pic`, `email_verified`, `email_otp`, `otp_expires_at`, `created_at`) VALUES
(1, 'Thanus Thapasvi Thummala', 't4872188@gmail.com', '$2y$10$/.IwfDSjkEsPgT6B2.NGGuYRSYbBPHmWcG/d6DaiKa8.VNtcJc0ey', 'admin', 4, 8, 0, '$2y$10$zRdXNLvBUSKaJDRFcVGd3OJq3QUsUGu8SoXleWJQpS0lwuiSx/E5e', '2026-02-08 09:32:00', '2026-01-28 09:17:44'),
(4, 'Hasty Crafter', 'hastycraftersofficial@gmail.com', '$2y$10$WQGTYiD8y5h.PjYViGdnv.CsmspLP5cPWTCx/qLmdL1o8AknIIBlG', 'fresher', 0, 0, 1, NULL, NULL, '2026-02-18 16:48:07'),
(5, 'Atul', 'atulbhakra@gmail.com', '$2y$10$sXHyAmPglLxZ0.H1Hg9bZehQXAM69OzGIte4z0rIbaCCTeE4ilFGq', 'alumni', 4, 2, 1, NULL, NULL, '2026-02-18 16:49:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `company_faqs`
--
ALTER TABLE `company_faqs`
  ADD PRIMARY KEY (`company_id`,`faq_id`),
  ADD KEY `faq_id` (`faq_id`);

--
-- Indexes for table `experience_bookmarks`
--
ALTER TABLE `experience_bookmarks`
  ADD PRIMARY KEY (`user_id`,`experience_id`),
  ADD KEY `experience_id` (`experience_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interview_experiences`
--
ALTER TABLE `interview_experiences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`company_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `signup_otps`
--
ALTER TABLE `signup_otps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `interview_experiences`
--
ALTER TABLE `interview_experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `signup_otps`
--
ALTER TABLE `signup_otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company_faqs`
--
ALTER TABLE `company_faqs`
  ADD CONSTRAINT `company_faqs_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_faqs_ibfk_2` FOREIGN KEY (`faq_id`) REFERENCES `faqs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `experience_bookmarks`
--
ALTER TABLE `experience_bookmarks`
  ADD CONSTRAINT `experience_bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `experience_bookmarks_ibfk_2` FOREIGN KEY (`experience_id`) REFERENCES `interview_experiences` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interview_experiences`
--
ALTER TABLE `interview_experiences`
  ADD CONSTRAINT `interview_experiences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interview_experiences_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
