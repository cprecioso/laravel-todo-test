import userEvent from "@testing-library/user-event";

const user = userEvent.setup();

document.body.addEventListener("click", async ({ target }) => {
    if (
        !(target instanceof HTMLElement) ||
        !target.classList.contains("login-as-button")
    )
        return;

    const email = target.dataset.email;
    const password = target.dataset.password;
    if (!email || !password) throw new Error("Email and password are required");

    const emailInput = document.querySelector('input[autocomplete="email"]');
    const passwordInput = document.querySelector(
        'input[autocomplete="current-password"]',
    );
    if (
        !emailInput ||
        !passwordInput ||
        !(emailInput instanceof HTMLInputElement) ||
        !(passwordInput instanceof HTMLInputElement)
    )
        throw new Error("Email and password inputs not found");

    await user.type(emailInput, email);
    await user.type(passwordInput, password);

    const submitButton = document.querySelector('button[type="submit"]');
    if (!submitButton || !(submitButton instanceof HTMLButtonElement))
        throw new Error("Submit button not found");
    await user.click(submitButton);
});
