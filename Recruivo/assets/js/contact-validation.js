document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#contact-form");
    const nameField = document.querySelector("#name");
    const emailField = document.querySelector("#email");
    const subjectField = document.querySelector("#subject");
    const messageField = document.querySelector("#message");

    const errorMessages = {
        nameError: document.querySelector("#name-error"),
        emailError: document.querySelector("#email-error"),
        subjectError: document.querySelector("#subject-error"),
        messageError: document.querySelector("#message-error"),
    };

    // Validation Functions
    const validateName = () => {
        const name = nameField.value.trim();
        errorMessages.nameError.textContent = "";
        if (!name) {
            errorMessages.nameError.textContent = "Full name is required.";
            return false;
        }
        return true;
    };

    const validateEmail = () => {
        const email = emailField.value.trim();
        errorMessages.emailError.textContent = "";
        const emailRegex = /\S+@\S+\.\S+/;
        if (!email) {
            errorMessages.emailError.textContent = "Email is required.";
            return false;
        }
        if (!emailRegex.test(email)) {
            errorMessages.emailError.textContent = "Invalid email format.";
            return false;
        }
        return true;
    };

    const validateSubject = () => {
        const subject = subjectField.value.trim();
        errorMessages.subjectError.textContent = "";
        if (!subject) {
            errorMessages.subjectError.textContent = "Subject is required.";
            return false;
        }
        return true;
    };

    const validateMessage = () => {
        const message = messageField.value.trim();
        errorMessages.messageError.textContent = "";
        if (!message) {
            errorMessages.messageError.textContent = "Message is required.";
            return false;
        }
        return true;
    };

    // Real-Time Validation
    nameField.addEventListener("input", validateName);
    emailField.addEventListener("input", validateEmail);
    subjectField.addEventListener("input", validateSubject);
    messageField.addEventListener("input", validateMessage);

    // Form Submit Validation
    form.addEventListener("submit", (event) => {
        const isNameValid = validateName();
        const isEmailValid = validateEmail();
        const isSubjectValid = validateSubject();
        const isMessageValid = validateMessage();

        if (!isNameValid || !isEmailValid || !isSubjectValid || !isMessageValid) {
            event.preventDefault();
        }
    });
});