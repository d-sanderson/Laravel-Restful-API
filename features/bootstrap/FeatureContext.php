<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->bearerToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImM2YzhjODhmYjQyNjE1ODI5MzJlNmM4MTcwNzU3MTMzODcxYzFiZmMwMjZiODcxNzFjYzZkN2EzNDVhZmU2ZDNlYTVhOGMyN2RmOTNkYjY2In0.eyJhdWQiOiI0IiwianRpIjoiYzZjOGM4OGZiNDI2MTU4MjkzMmU2YzgxNzA3NTcxMzM4NzFjMWJmYzAyNmI4NzE3MWNjNmQ3YTM0NWFmZTZkM2VhNWE4YzI3ZGY5M2RiNjYiLCJpYXQiOjE1NTU1NjE2MjAsIm5iZiI6MTU1NTU2MTYyMCwiZXhwIjoxNTg3MTg0MDIwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.i57xtfmLkJ2BPCU24YM4qPv4eMN61U51Xc1NxiLrYajxU9RqoT3a5fDxvrzXS7p2EoPNRH50aypS8T0nHNZZMAQZTKpDoMxPQJTB7RNahIILOMJS_OvR3_AMNoILs-HL7j9LdKl-QCnf9sBDgHTHSDAhPDUW7oTpuv3whPcMHs80iO91hROaekGzNY33__MNxqDJHO-5f0gSPcJAHaNYJwU6tUQYRTRYWFUHKXPXW3r4Qw2YD6QTs4xgCb9_sMR9mq6sjQNkaxRyBJN5tT2ZBA7YzMMkQDRkVw6N-7llyUnD84zl9KQDch_TPKznKyQrc6v0rpElAr6J4ySJlh1zarGPZIFOgCAd7WRZXE6Uoty-QOeJZzHq4tDD37SZgAqLeR_Ie0W3Gd0lqqY4OKTZS7fLJYZmOGsgeF9Gn9t8bBJHrGS0-id8n3S_8NJCgt2h4ETGT0VqvzQLckCz4PFEDRybGPc6yOf-KtkAIICRWerBQoTLASAsrARfH4Coc8jIELUxDEjlGsfZu00YZUGuVn0NCpE6k33Y3F_hXc92FUgxY0Qtt6-0SCsMtaT-YH4wNKivPeWRGtNst41uKNN_iAc1_C-8QIvp5LEbKN8q0ZUUnHbBBP5eBEi0kS-Fi4CqGlPrvtmWYHJcfeqFny8FauCViGkAHsn04YeWP_jDVNY";
    }

    /**
     * @Given I have the payload:
     */
    public function iHaveThePayload(PyStringNode $string)
    {
        $this->payload = $string;
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)"$/
     */
    public function iRequest($httpMethod, $argument1)
    {
        $client = new GuzzleHttp\Client();
        $this->response = $client->request(
            $httpMethod,
            'http://127.0.0.1:8000' . $argument1,
            [
                'body' => $this->payload,
                'headers' => [
                    "Authorization" => "Bearer {$this->bearerToken}",
                    "Content-Type" => "application/json",
                ],
            ]
        );
        $this->responseBody = $this->response->getBody(true);
    }

    /**
     * @Then /^I get a response$/
     */
    public function iGetAResponse()
    {
        if (empty($this->responseBody)) {
            throw new Exception('Did not get a response from the API');
        }
    }

    /**
     * @Given /^the response is JSON$/
     */
    public function theResponseIsJson()
    {
        $data = json_decode($this->responseBody);

        if (empty($data)) {
            throw new Exception("Response was not JSON\n" . $this->responseBody);
        }
    }

      /**
     * @Then the response contains :arg1 records
     */
    public function theResponseContainsRecords($arg1)
    {
        $data = json_decode($this->responseBody);
        $count = count($data);
        return ($count == $arg1);
    }
     /**
     * @Then the questions contains a title of :arg1
     */
    public function theQuestionsContainsATitleOf($arg1)
    {
        $data = json_decode($this->responseBody);
        if($data->title == $arg1) {

        } else {
            throw new Exception('The title does not match');
        }
    }
}