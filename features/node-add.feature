Feature: Check basic page CT
 In order to create a page
 As an admin
 I want to access /node/add/page
 So that I can create a page

@api @javascript
Scenario: Basic Page CT
 Given I am logged in as a user with the "administrator" role
 When I go to "/node/add/page"
 And I enter "Basic page title" for "edit-title-0-value"
 And I fill in wysiwyg on field "edit-body-0-value" with "Basic page content"
 When I press "edit-submit"
 Then I should see "Basic page Basic page title has been created"