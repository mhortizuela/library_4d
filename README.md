# Library API
# API Documentation

## Table of Contents

- [Overview](#overview)
- [Base URL](#base-url)
- [Authentication](#authentication)
- [Endpoints](#endpoints)
  - [User Authentication](#user-authentication)
  - [Students Management](#students-management)
  - [Attendance Management](#attendance-management)
- [Error Handling](#error-handling)
- [Status Codes](#status-codes)
- [Changelog](#changelog)
- [Contact](#contact)

---

## Overview

This API provides access to manage student records, user authentication, and attendance tracking. It follows RESTful principles and supports CRUD operations.

---

## Base URL


---

## Authentication

All endpoints (except login) require a **Bearer Token** for authentication.

### Obtaining a Token

**Endpoint:** `POST /auth/login`

**Request:**

`
{
  "username": "your_username",
  "password": "your_password"
}`

**Result:**
`{
  "token": "your_jwt_token",
  "userId": 123,
  "expiresIn": 3600
}`

# Adding Authors

An endpoint for adding authors

**Endpoint:** `POST /authors/add`

**Request:**

`
{
  "author": "name"
}`

**Result:**
`{
  "status": "success",
  "data": null
}`

