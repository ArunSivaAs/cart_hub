# ARUN A S

# Que

Build an application that can be used to generate Invoices. 
○	Users should be able to add multiple line items by providing the following details.
a. Name
b. Quantity
c. Unit Price (in $)
d. Tax ( should be one of these 0%, 1%, 5%, 10%)
○	The following should be calculated and displayed on the page
a. Line Total against each item
b. Subtotal without tax
c. Subtotal with tax
○	Users should be able to provide a discount on top of the Subtotal with tax. Discount can be a percentage(%) value or an amount ($).
○	The total Amount should be shown at the bottom of the list after applying the discount.
○	 A "Generate Invoice" button should be provided and upon clicking it, all the information should be neatly displayed in a printable format.

# Configuration

1. Open XAMPP control panel and start the Apache and MySQL.
2. Extract the folder and copy the online_cart_hub folder into " C:\xampp\htdocs ".
3. Create a new database in MySQL with name "my_shop".
4. Open the database folder in online_cart_hub and import the file my_shop.sql into newly created database.
5. To run the application copy the url and paste on your browser ".
http://localhost/online_cart_hub/
