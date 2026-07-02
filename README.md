# TechRefurb Store 🛒

A full-stack tech refurbished products shopping website built for my internship at Mannai Technologies.

## 🌐 About
TechRefurb is an e-commerce platform for buying certified refurbished laptops, phones, and accessories in Qatar. Products are graded (A/B/C) so customers know exactly what they're getting.

## ✨ Features
- 🏠 Homepage with featured products from database
- 🛍️ Products page with search and category/grade filters
- 🔐 User registration, login and logout with sessions
- 🛒 Shopping cart (add, remove, quantity tracking)
- 💳 Checkout with delivery form and payment method
- 📦 My Orders page with order history and status
- ℹ️ About page with grade explanation
- 📩 Contact page with message form
- 🔧 Admin panel (add, edit, delete products + revenue stats)
- 🔒 Separate admin login system

## 🛠️ Tech Stack
| Layer | Technology |
|-------|-----------|
| Frontend | HTML, CSS |
| Backend | PHP |
| Database | MySQL |
| Server | Apache (XAMPP) |
| Version Control | Git & GitHub |

## 📁 Project Structure
techrefurb-store/
├── index.php          # Homepage
├── products.php       # All products with search & filters
├── cart.php           # Shopping cart
├── checkout.php       # Checkout page
├── orders.php         # My orders
├── login.php          # Login & register
├── logout.php         # Logout
├── about.php          # About page
├── contact.php        # Contact page
├── admin.php          # Admin panel
├── admin_login.php    # Admin login
├── css/
│   └── style.css      # All styles
└── php/
└── config.php     # Database connection

## 🗄️ Database Tables
- **users** — registered customers
- **products** — refurbished products with grade and stock
- **cart** — user cart items
- **orders** — placed orders
- **order_items** — individual items per order

## 👨‍💻 Developer
Built by Anantrop Sahi — CS (AI) student at Barzan University College, intern at Mannai Technologies, Doha Qatar.
