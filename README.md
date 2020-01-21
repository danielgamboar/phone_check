#### This script checks for phone numbers from Alcazar Networks API

1. It grabs phone number from a `.csv` file
2. Checks for API response
3. Create a new `.csv` file with the response for each number

The script checks for a file called `phones.csv`, then it reads line by line the phone number, takes the responses, push it into an array, after all number where checked, it creates a new `.csv` file.
