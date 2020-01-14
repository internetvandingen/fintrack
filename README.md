# Fintrack
Track your personal finances with a single application for multiple bank accounts from different banks.
Upload your transactions in csv format and assign ledgers to the transactions.
Easy overview of how much you spend on food, transport, etc.

### Design
Model View Control design is used to develop this application.
Basic functions for MVC are add, view, edit and delete.

#### Use cases
Title | Precondition | Postcondition | Story | Exceptions
----- | ------------ | ------------- | ----- | ----------
Add/modify user | None | Modified user | Fill in details of user | email already exists
MVC for Accounts | User exists | Modified account | Fill in details of account | None
MVC for Ledgers | User exists | Modified ledger | Fill in details of ledgers | None
MVC for Transaction | User and account exists | Modified Transaction | Fill in details of ledgers | None
Upload csv file | User and account exists | Every transaction is in database | Upload csv file | Missing values
Assign ledgers | Transactions exist and user has ledgers | Every transaction has a ledger | For every transaction choose a ledger | None
Search transaction | User exists | Result of search is shown | Wants to search for specific transaction | None



### Future features
- [x] Implement MVC
  - [x] Users
  - [x] Accounts
  - [x] Ledgers
  - [x] Transactions
- [x] Authentication (login/logout)
- [x] Authorization
- [x] Upload csv
- [x] Assign ledgers per transactions
- [x] Sidebars and menu
  - [x] Users
  - [x] Accounts
  - [x] Ledgers
  - [x] Transactions
- [ ] Search function for transactions
- [ ] Statistics (graphs)
- [ ] Expense predictions

### Database structure:
```SQL
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created DATETIME,
    modified DATETIME,
    UNIQUE KEY (email)
);

CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bank_number VARCHAR(34) NOT NULL,
    balance INT NOT NULL,
    name VARCHAR(255),
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY user_key (user_id) REFERENCES users(id)
) CHARSET=utf8mb4;

CREATE TABLE ledgers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255),
    description VARCHAR(255),
    balance INT NOT NULL,
    color CHAR(6),
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY user_ledger_key (user_id) REFERENCES users(id)
) CHARSET=utf8mb4;

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    amount INT NOT NULL,
    counter_account VARCHAR(34) NOT NULL,
    date DATETIME NOT NULL,
    ledger_id INT,
    description VARCHAR(255),
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY account_key (account_id) REFERENCES accounts(id),
    FOREIGN KEY ledger_key (ledger_id) REFERENCES ledgers(id)
) CHARSET=utf8mb4;
```

### Licence
Intentionally without licence
