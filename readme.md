# Students-Profile

This demonstrates how to use classes in PHP CRUD.

## Model

province -> id (PK, AI), name  
town_city -> id (PK, AI), name  
students -> id (PK, AI), student_number, first_name, last_name, middle_name, gender, birthday  
student_details -> id (PK, AI), student_id (int), contact_number, street, town_city (FK), province (int), zip_code
