        Feature: Website requeirment: Website home page.
          As a visitor to the website 
          I want to navigate to the home page
          So that I will be able to see all homepage content

          @javascript @init @check
          Scenario: check the welcome message at the homepage
            Given I am an anonymous user
            When I go to the homepage
            Then I should see "No front page content has been created yet."
      