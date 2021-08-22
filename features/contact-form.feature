@api @javascript
Feature: Contact form
  In order to send a message to the site administrators
  As a visitor
  I should be able to use the site-wide contact form

  Scenario: A visitor can use the site-wide contact form
    Given I am at "contact/feedback"
    When I fill in "name" with "John Doe"
    And I fill in "mail" with "john@doe.com"
    And I fill in "subject[0][value]" with "Hello world"
    And I fill in "message[0][value]" with "Lorem Ipsum"
    And I press "Send message"
    Then I should see the text "Your message has been sent."