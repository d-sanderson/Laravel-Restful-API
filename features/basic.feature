Feature: Sample Tests
In order to test the APPI
I need to be able to test the APPI

Scenario: Get Questions
Given I have the payload: 
"""
"""
When I request "GET /api/questions"
Then the response is JSON