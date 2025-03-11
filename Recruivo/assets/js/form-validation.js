document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form"); // Select the form dynamically (works for both login and register)
    const email = document.querySelector("#email");
    const password = document.querySelector("#password");
    const confirmPassword = document.querySelector("#confirm_password"); // Only relevant for register.php
    const name = document.querySelector("#name"); // Only relevant for register.php
    const role = document.querySelector("#role"); // Only relevant for register.php

    const errors = {
        email: document.querySelector("#email-error"),
        password: document.querySelector("#password-error"),
        confirmPassword: document.querySelector("#confirm-password-error"),
        name: document.querySelector("#name-error"),
        role: document.querySelector("#role-error"),
    };

    // Clear error messages
    const clearErrors = () => {
        Object.values(errors).forEach((errorElement) => {
            if (errorElement) errorElement.textContent = "";
        });
    };

    // Validate email
    const validateEmail = () => {
        if (!email.value.trim()) {
            errors.email.textContent = "Email is required.";
            return false;
        } else if (!/\S+@\S+\.\S+/.test(email.value.trim())) {
            errors.email.textContent = "Invalid email format.";
            return false;
        }
        return true;
    };

    // Validate password
    const validatePassword = () => {
        if (!password.value.trim()) {
            errors.password.textContent = "Password is required.";
            return false;
        }
        return true;
    };

    // Validate confirm password (only for register.php)
    const validateConfirmPassword = () => {
        if (!confirmPassword) return true; // Skip validation for login.php
        if (!confirmPassword.value.trim()) {
            errors.confirmPassword.textContent = "Confirm password is required.";
            return false;
        } else if (password.value.trim() !== confirmPassword.value.trim()) {
            errors.confirmPassword.textContent = "Passwords do not match.";
            return false;
        }
        return true;
    };

    // Validate name (only for register.php)
    const validateName = () => {
        if (!name) return true; // Skip validation for login.php
        if (!name.value.trim()) {
            errors.name.textContent = "Full name is required.";
            return false;
        }
        return true;
    };

    // Validate role (only for register.php)
    const validateRole = () => {
        if (!role) return true; // Skip validation for login.php
        if (!role.value.trim()) {
            errors.role.textContent = "User role is required.";
            return false;
        }
        return true;
    };

    // Form submit event handler
    form.addEventListener("submit", (event) => {
        clearErrors(); // Reset error messages

        // Perform validation checks
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();
        const isConfirmPasswordValid = validateConfirmPassword();
        const isNameValid = validateName();
        const isRoleValid = validateRole();

        // Prevent form submission if any validation fails
        if (!isEmailValid || !isPasswordValid || !isConfirmPasswordValid || !isNameValid || !isRoleValid) {
            event.preventDefault();
        }
    });
});