<!DOCTYPE html>
<html>
<head>
    <title>MediConnect - Book Appointment</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin: 20px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #4f46e5; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #3730a3; }
        .success { background: #d1fae5; color: #065f46; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>🏥 MediConnect</h1>
    <p>Book your healthcare appointment online</p>

    <?php
    if ($_POST) {
        require_once 'config/database.php';
        
        try {
            $db = Database::getInstance()->getConnection();
            
            $stmt = $db->prepare("INSERT INTO appointments (patient_id, provider_id, appointment_date, appointment_time, appointment_type, notes) VALUES (1, 1, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['date'],
                $_POST['time'],
                $_POST['type'],
                $_POST['notes']
            ]);
            
            echo '<div class="success">✅ Appointment booked successfully!</div>';
        } catch (Exception $e) {
            echo '<div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 5px;">❌ Error: ' . $e->getMessage() . '</div>';
        }
    }
    ?>

    <form method="POST">
        <div class="form-group">
            <label>Provider</label>
            <select name="provider" required>
                <option>Dr. Sarah Smith - General Practice</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
        </div>

        <div class="form-group">
            <label>Time</label>
            <select name="time" required>
                <option value="09:00">9:00 AM</option>
                <option value="09:30">9:30 AM</option>
                <option value="10:00">10:00 AM</option>
                <option value="10:30">10:30 AM</option>
                <option value="11:00">11:00 AM</option>
                <option value="14:00">2:00 PM</option>
                <option value="14:30">2:30 PM</option>
                <option value="15:00">3:00 PM</option>
                <option value="15:30">3:30 PM</option>
                <option value="16:00">4:00 PM</option>
            </select>
        </div>

        <div class="form-group">
            <label>Appointment Type</label>
            <select name="type" required>
                <option value="">Select type</option>
                <option value="consultation">General Consultation</option>
                <option value="checkup">Health Check-up</option>
                <option value="follow-up">Follow-up</option>
                <option value="urgent">Urgent Care</option>
            </select>
        </div>

        <div class="form-group">
            <label>Notes (optional)</label>
            <textarea name="notes" rows="3" placeholder="Any specific concerns..."></textarea>
        </div>

        <button type="submit">Book Appointment</button>
    </form>

    <hr>
    <h3>Recent Appointments</h3>
    <?php
    require_once 'config/database.php';
    try {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM appointments ORDER BY id DESC LIMIT 5");
        $appointments = $stmt->fetchAll();
        
        if ($appointments) {
            foreach ($appointments as $apt) {
                echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
                echo "<strong>Date:</strong> " . $apt['appointment_date'] . " at " . $apt['appointment_time'] . "<br>";
                echo "<strong>Type:</strong> " . $apt['appointment_type'] . "<br>";
                echo "<strong>Status:</strong> " . $apt['status'] . "<br>";
                if ($apt['notes']) echo "<strong>Notes:</strong> " . $apt['notes'];
                echo "</div>";
            }
        } else {
            echo "<p>No appointments yet.</p>";
        }
    } catch (Exception $e) {
        echo "<p>Error loading appointments.</p>";
    }
    ?>
</body>
</html>
