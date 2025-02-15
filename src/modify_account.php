<?php
session_start();
require '../app/db.php';

$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT username, email, telefon, nume FROM client WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Account</title>
    <link href="modify_account.css" rel="stylesheet">
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="outer-container">
        <h2>My Account</h2>
        <table>
            <tr>
                <th>Field</th>
                <th>Value</th>
                <th>Action</th>
            </tr>
            <?php foreach ($user as $field => $value): ?>
                <tr>
                    <td><?php echo ucfirst($field); ?></td>
                    <td id="<?php echo $field; ?>_value"><?php echo htmlspecialchars($value); ?></td>
                    <td>
                        <?php if ($field !== 'username' && $field !== 'email'): ?>
                            <button onclick="editField('<?php echo $field; ?>')">Change</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td>Password</td>
                <td>********</td>
                <td>
                    <button onclick="showPasswordForm()">Change Password</button>
                </td>
            </tr>
        </table>

        <form id="updateForm" method="post" action="update_account.php" onsubmit="return validateForm()">
            <input type="hidden" name="field" id="field">
            <label for="new_value">New Value:</label>
            <input type="text" name="new_value" id="new_value">
            <button type="submit">Save</button>
            <p id="error_msg"></p>
        </form>

        <form id="passwordForm" method="post" action="change_password.php" onsubmit="return validatePasswordForm()">
            <h3>Change Password</h3>
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" required>

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit">Update Password</button>
            <p id="password_error_msg"></p>
        </form>
    </div>

    <script>
        function editField(field) {
            let currentValue = document.getElementById(field + "_value").textContent;
            document.getElementById("field").value = field;
            document.getElementById("new_value").value = currentValue;
            document.getElementById("updateForm").style.display = "block";
            document.getElementById("passwordForm").style.display = "none";
        }

        function showPasswordForm() {
            document.getElementById("updateForm").style.display = "none";
            if (document.getElementById("passwordForm").style.display == "block") {
                document.getElementById("passwordForm").style.display = "none";
            } else {
                document.getElementById("passwordForm").style.display = "block";
            }
        }

        function validateForm() {
            let field = document.getElementById("field").value;
            let newValue = document.getElementById("new_value").value.trim();
            let errorMsg = document.getElementById("error_msg");

            errorMsg.textContent = "";

            if (!newValue) {
                errorMsg.textContent = "Value cannot be empty.";
                return false;
            }

            if (field === "telefon" && !/^\d{10,15}$/.test(newValue)) {
                errorMsg.textContent = "Invalid phone number. Only digits allowed (10-15 characters).";
                return false;
            }

            if ((field === "username" || field === "nume") && !/^[a-zA-ZăâîșțĂÂÎȘȚ\s]+$/.test(newValue)) {
                errorMsg.textContent = "Invalid name. Only letters and spaces allowed.";
                return false;
            }

            if (field === "email" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(newValue)) {
                errorMsg.textContent = "Invalid email format.";
                return false;
            }

            return true;
        }

        function validatePasswordForm() {
            let currentPassword = document.getElementById("current_password").value.trim();
            let newPassword = document.getElementById("new_password").value.trim();
            let confirmPassword = document.getElementById("confirm_password").value.trim();
            let errorMsg = document.getElementById("password_error_msg");

            errorMsg.textContent = "";

            if (!currentPassword || !newPassword || !confirmPassword) {
                errorMsg.textContent = "All fields are required.";
                return false;
            }

            if (newPassword.length < 4) { //normally 8, now 4 for testing purposes
                errorMsg.textContent = "Password must be at least 8 characters.";
                return false;
            }

            if (newPassword !== confirmPassword) {
                errorMsg.textContent = "New passwords do not match.";
                return false;
            }

            return true;
        }
    </script>
</body>
</html>