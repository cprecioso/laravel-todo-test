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

    const emailInput = getEl('input[autocomplete="email"]', HTMLInputElement);
    const passwordInput = getEl(
        'input[autocomplete="current-password"]',
        HTMLInputElement,
    );
    const submitButton = getEl('button[type="submit"]', HTMLButtonElement);

    await user.clear(emailInput);
    await user.type(emailInput, email);

    await user.clear(passwordInput);
    await user.type(passwordInput, password);

    await user.click(submitButton);
});

function getEl<T extends HTMLElement>(
    selector: string,
    class_: { new (...args: unknown[]): T },
): T {
    const el = document.querySelector(selector);
    if (!el) throw new Error(`"${selector}" not found`);
    if (!(el instanceof class_))
        throw new Error(`"${selector}" not a ${class_.name}`);
    return el;
}
