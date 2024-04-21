-- Benyas Questions

CREATE TABLE IF NOT EXISTS test_list (
   test_list_id INT PRIMARY KEY AUTO_INCREMENT,
   name TEXT NOT NULL,
   difficulity TEXT NOT NULL,
   prepared_by TEXT NOT NULL
);

INSERT INTO test_list(name, difficulity, prepared_by) VALUES(
"JavaScript",
"Medium",
"Benyas Berhanu"
),
(
   "HTML",
   "Medium",
   "Benyas Berhanu"
);

INSERT INTO tests (question,answer,a,b,c,d,subject) VALUES (
        "What is the output of this code? <code>console.log(1/0)</code>",
  		"c",
  		"null",
        "undefined",
        "Infinity",
  		"0",
  		"JavaScript"
);

INSERT INTO tests (question,answer,a,b,c,d,subject) VALUES (
        "What is the output of this code? <code>console.log(typeof 123)</code>",
  		"b",
  		"int",
        "number",
        "string",
  		"Shows error that says bracket missing",
  		"JavaScript"
);

INSERT INTO tests (question,answer,a,b,c,d,subject) VALUES (
        "What is Node.js",
  		"c",
  		"Programming language",
        "JavaScript framework ",
        "JavaScript Runtime environment",
  		"JavaScript to machine code translator",
  		"JavaScript"
);

INSERT INTO tests (question,answer,a,b,c,d,subject) VALUES (
        "What does the acronym HTML mean",
  		"d",
  		"Hyper text meaning Language",
        "Hyper text makeup language",
        "Hyper transformation making language",
  		"Hyper text markup language",
  		"HTML"
);

INSERT INTO tests (question,answer,a,b,c,d,subject) values (
   "What is the name of the <code>a tag</code>",
  "b",
  "address",
  "anchor",
  "another",
  "It is just a representation",
  "HTML"
);
INSERT INTO tests (question,answer,a,b,c,d,subject) values (
   "What is the use of CSS?",
  "a",
  "To design our pages",
  "To make our pages faster",
  "To handle button clicks",
  "None",
  "HTML"
);

INSERT INTO tests (question,answer,a,b,c,d,subject) values (
   "What is the use of the <code>hr</code> tag?",
  "d",
  "To create a horizontal row",
  "To make a text look brighter",
  "To create a alternative for the <code>'<b'></code> tag",
  "To create a horizontal line",
  "HTML"
);
INSERT INTO tests (question,answer,a,b,c,d,subject) values (
   "What is the code to create a image?",
  "c",
  "<code>'<im>'</code>",
  "<code>'<image>'</code>",
  "<code>'<img>'</code>",
  "<code>'<pic>'</code>",
  "HTML"
);
INSERT INTO tests (question,answer,a,b,c,d,subject) values (
   "What is the use of <code>document.querySelector</code>?",
  "c",
  "To get a specific console window",
  "To get an element based on class",
  "To get an element as we select in css",
  "To get an element as in the query cache",
  "JavaScript"
);

INSERT INTO tests (question, answer, a, b, c, d,subject) VALUES(
   "Let the object be <code>let obj = {a:1,b:2}</code>, How can I get the output 1?",
   "a",
   "obj.a",
   "obj.a:1",
   "obj[a]",
   "obj",
   "JavaScript"
);

