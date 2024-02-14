# foroclismo
Laravel forum created for learning purposes

    Learned:
        Basics: 
            Routing, Middleware, CSRF, Controllers, Requests, Responses, Views, Blade, Session,Validation
        Mailer, to send automatic mails
        
        Model:
            Migrations, seedings, eloquent and Factories
    
        Testing:
            Unit Testing: Used to test a single portion of our app, normally single methods or services.
            Feature Testing: Used to test more parts of our app, like HTTP requests, or classes that interact with other classes.
            TDD: Write the tests before writing the actual code, so we kinda have a script (like a movie) that will fail in the beginning
            and our code must validate that script (test).

        PHP:
            Traits, interfaces
        
        Directory pattern for laravel
        
        Architecture:
            Service container -> Used to configure all app, we can for example bind the instance of an interface and use the interface.
            Service providers -> Used to register classes so we can inject them, we can bind them (factory) or singleton them.
            Facades -> Static methods
            Repository pattern -> Methods that our controllers will use to interact with the Model.
