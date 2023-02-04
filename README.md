# Database dumps before / after POST request
![image](https://user-images.githubusercontent.com/75832820/216766828-b2dea471-4ab7-4d6a-8194-a2fd6a47a4cf.png)
![image](https://user-images.githubusercontent.com/75832820/216766407-edcf1543-464a-4745-812f-9102cca2e4a1.png)
![image](https://user-images.githubusercontent.com/75832820/216766431-c422feaf-61d6-4e6c-8028-27dc32e9926e.png)
![image](https://user-images.githubusercontent.com/75832820/216766449-333ba409-ff0e-4fe7-adc3-216032130ca3.png)
![image](https://user-images.githubusercontent.com/75832820/216766461-06634ae3-2975-4fcf-b679-e34cc1808c4a.png)
![image](https://user-images.githubusercontent.com/75832820/216766478-698c0db8-6bbf-4065-998a-4192f990f615.png)


# Symfony REST API
This Symfony REST API is a CRUD (Create, Read, Update, Delete) application that allows for easy management of data through various HTTP requests.

# Getting Started
To use this API, you'll need to follow these steps:

1. Clone the repository
2. Install the dependencies by running composer install
3. Create a database and configure the '.env' file with your database credentials
4. Run the command <code>php bin/console doctrine:migrations:migrate</code> to apply the database migrations
5. Finally, run the command <code>symfony server:start</code> to start the development server

# Endpoints
The following endpoints are available for you to interact with the API:

# POST /groups
This endpoint is used to create a new group. The required fields are (e.g.):

<code>
{
    "nomDuGroupe": "The Beatles",
    "origine": "UK",
    "ville": "Liverpool",
    "anneeDebut": 1960,
    "anneeSeparation": 1970,
    "fondateurs": ["John Lennon", "Paul McCartney"],
    "membres": ["John Lennon", "Paul McCartney", "George Harrison", "Ringo Starr"],
    "courantMusical": "Rock",
    "presentation": "The Beatles were an English rock band, formed in Liverpool in 1960."
}</code>

# GET /groups
This endpoint is used to retrieve a list of all groups.

# GET /groups/{id}
This endpoint is used to retrieve a specific group based on the provided id.

# PUT /groups/{id}
This endpoint is used to update a specific group based on the provided id.

# DELETE /groups/{id}
This endpoint is used to delete a specific group based on the provided id.

# Technologies
This API is built using:
<ul>
<li>Symfony 5</li>
<li>Doctrine</li>
<li>PHP 8.0</li>
</ul>

# Conclusion
This API provides a simple and straightforward way to manage data using the CRUD operations. Whether you're a beginner or an experienced developer, you'll find this API a useful tool in your toolkit.
