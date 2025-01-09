# Text Prediction Bot

This project implements a simple bot that can predict the next character in a sequence based on previously learned text using n-grams. It features two commands: **learn** and **predict**.

## Installation

To install and set up the bot, follow these steps:

### Prerequisites

- PHP 7.4 or higher
- Composer (for dependency management)

### Steps to Install

1. Clone or download the repository to your local machine.

    ```bash
    git clone https://github.com/your-repo/text-prediction-bot.git
    cd text-prediction-bot
    ```

2. Install dependencies using Composer:

    ```bash
    composer install
    ```

3. Ensure your environment has PHP installed. You can verify it by running:

    ```bash
    php -v
    ```

## Commands

### 1. `learn` Command

The **learn** command trains the model with the provided text. It generates n-grams (default size of 3) and learns the most likely next character based on previous characters.

**Usage:**

```bash
php index.php learn "Your training text here"