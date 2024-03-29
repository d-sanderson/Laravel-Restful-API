Feature: Sample Tests
In order to test the APPI
I need to be able to test the APPI

Scenario: Get Questions
Given I have the payload: 
"""
"""
When I request "GET /api/questions"
Then the response is JSON
Then the response contains 50 records

Scenario: Add Question
Given I have the payload: 
"""
{
    "title": "Behat",
    "question": "Is it awesome?",
    "poll_id": 2
}
"""
When I request "POST /api/questions"
Then the response is JSON
Then the questions contains a title of "Behat"
