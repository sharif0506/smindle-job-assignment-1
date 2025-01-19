# Order Subscription Processing

## Overview

This project implements an order system using Laravel. It validates incoming order data, stores it in a database, and asynchronously processes subscription items by sending them to a third-party API.

## Key Features

- **Order Creation**: RESTful endpoint to receive and validate order data, including customer details and a basket of items (unit and subscription types).
- **Basket Table**: Separate `basket` table to store order items with a relationship to the `orders` table.
- **Asynchronous Subscription Handling**: Subscription items are sent to a third-party API (`https://very-slow-api.com/orders`) via Laravel queues.
- **Validation & Error Handling**: Incoming order data is validated. Errors are returned as JSON without redirecting to the homepage.
- **Queue Worker**: Subscription orders are processed asynchronously without blocking the main order creation process.
