# Fintrack

Intentionally without licence


# DB structure
- transactions
  - transaction_id (INT unsigned A_I)
  - account_id (INT unsigned)
  - amount (INT signed)
  - description (VARCHAR (255))
  - counter_account (VARCHAR (255))
  - datetime (DATETIME)
  - ledger_id (INT unsigned)

- accounts
  - account_id (INT unsigned A_I)
  - bank_number (VARCHAR (34))
  - balance (INT signed)
  - name (VARCHAR (255))
  - user_id (INT unsigned)

- ledgers
  - ledger_id (INT unsigned A_I)
  - user_id (INT unsigned)
  - name (VARCHAR)
  - description (VARCHAR)
  - balance (INT signed)

- users
  - user_id (int unsigned A_I)
  - first name (VARCHAR)
  - last name (VARCHAR)
  - email (VARCHAR)
  - username (VARCHAR)
  - password (VARCHAR)
