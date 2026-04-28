<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - <?php echo e($payment->id); ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        /* --- NEUMORPHISM UI THEME --- */
        :root {
            --neu-bg: #e0e5ec;
            --neu-shadow-dark: #a3b1c6;
            --neu-shadow-light: #ffffff;
            --neu-text: #333333;
            --brand-primary: #0d6efd;
            --brand-danger: #dc3545;
        }

        body {
            background-color: var(--neu-bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--neu-text);
        }

        /* The 3D Neumorphic Container */
        .receipt-wrapper {
            background-color: var(--neu-bg);
            border-radius: 25px;
            box-shadow: 12px 12px 24px var(--neu-shadow-dark),
                       -12px -12px 24px var(--neu-shadow-light);
            padding: 30px;
            width: 100%;
            max-width: 360px;
        }

        /* The Actual Receipt Paper inside */
        .receipt-paper {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px 20px;
            box-shadow: inset 4px 4px 10px rgba(0,0,0,0.06);
            font-family: 'Courier Prime', 'Courier New', monospace; /* Classic POS Font */
            color: #000;
        }

        /* Receipt Content Styles */
        .r-header { 
            text-align: center; 
            border-bottom: 2px dashed #cccccc; 
            padding-bottom: 15px; 
            margin-bottom: 15px; 
        }
        .r-header h2 { margin: 0; font-size: 22px; font-weight: 700; font-family: 'Poppins', sans-serif; text-transform: uppercase; }
        .r-header p { margin: 5px 0 0; font-size: 12px; color: #555; }

        .r-details { 
            font-size: 13px; 
            line-height: 1.6; 
            margin-bottom: 15px; 
            border-bottom: 2px dashed #cccccc; 
            padding-bottom: 15px; 
        }
        .r-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .r-label { font-weight: 700; }
        .r-value { text-align: right; }

        .r-amount { 
            text-align: center; 
            margin: 20px 0; 
            border-bottom: 2px dashed #cccccc; 
            padding-bottom: 20px; 
        }
        .r-amount span { display: block; font-size: 12px; color: #555; margin-bottom: 5px; font-weight: 600; }
        .r-amount h1 { margin: 0; font-size: 28px; color: #000; }

        .r-footer { 
            text-align: center; 
            font-size: 11px; 
            color: #555; 
        }
        .r-footer p { margin: 3px 0; }

        /* 3D Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .neu-btn {
            flex: 1;
            background-color: var(--neu-bg);
            border: none;
            border-radius: 15px;
            padding: 14px;
            font-weight: 700;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            color: var(--neu-text);
            box-shadow: 6px 6px 12px var(--neu-shadow-dark),
                       -6px -6px 12px var(--neu-shadow-light);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
        .neu-btn:hover { transform: translateY(-2px); }
        .neu-btn:active {
            box-shadow: inset 4px 4px 8px var(--neu-shadow-dark),
                        inset -4px -4px 8px var(--neu-shadow-light);
            transform: translateY(2px);
        }
        .btn-print { color: var(--brand-primary); }
        .btn-close { color: var(--brand-danger); }

        /* --- THERMAL PRINTER STYLES (80mm width standard) --- */
        @media print {
            body { 
                background: #fff !important; 
                align-items: flex-start; 
                justify-content: flex-start;
                padding: 0;
                margin: 0;
            }
            .receipt-wrapper { 
                box-shadow: none !important; 
                padding: 0 !important; 
                max-width: 80mm; /* Standard thermal printer width */
                width: 100%; 
                border-radius: 0; 
                margin: 0 auto; 
            }
            .receipt-paper { 
                box-shadow: none !important; 
                border-radius: 0 !important; 
                padding: 0 !important; 
                margin: 0; 
            }
            .action-buttons { display: none !important; }
            
            /* Force Black & White colors for thermal print */
            .r-header h2, .r-amount h1, .r-row, .r-label, .r-value { color: #000 !important; }
            .r-header p, .r-amount span, .r-footer { color: #000 !important; opacity: 1 !important; }
            .r-header, .r-details, .r-amount { border-bottom: 1px dashed #000 !important; }
        }
    </style>
</head>
<body onload="window.print();">

<div class="receipt-wrapper">
    
    <div class="receipt-paper">
        <div class="r-header">
            <h2>SMART INSTITUTE</h2>
            <p>Class Management System</p>
        </div>
        
        <div class="r-details">
            <div class="r-row">
                <span class="r-label">Receipt No:</span> 
                <span class="r-value">#<?php echo e(str_pad($payment->id, 5, '0', STR_PAD_LEFT)); ?></span>
            </div>
            <div class="r-row">
                <span class="r-label">Date:</span> 
                <span class="r-value"><?php echo e($payment->created_at->format('Y-m-d h:i A')); ?></span>
            </div>
            
            <br>
            
            <?php if($payment->student): ?>
                <div class="r-row">
                    <span class="r-label">Student:</span> 
                    <span class="r-value"><?php echo e($payment->student->student_name); ?></span>
                </div>
                <div class="r-row">
                    <span class="r-label">Index No:</span> 
                    <span class="r-value"><?php echo e($payment->student->card_number); ?></span>
                </div>
            <?php else: ?>
                <div class="r-row">
                    <span class="r-label">Student:</span> 
                    <span class="r-value" style="color: red;">N/A (Deleted)</span>
                </div>
            <?php endif; ?>
            
            <br>

            <?php if($payment->course): ?>
                <div class="r-row">
                    <span class="r-label">Course:</span> 
                    <span class="r-value"><?php echo e($payment->course->course_name); ?></span>
                </div>
            <?php endif; ?>
            
            <div class="r-row">
                <span class="r-label">Type:</span> 
                <span class="r-value"><?php echo e($payment->month == 'Daily' ? 'Day Payment' : 'Monthly ('.$payment->month.')'); ?></span>
            </div>
        </div>

        <div class="r-amount">
            <span>TOTAL PAID</span>
            <h1>Rs. <?php echo e(number_format($payment->amount, 2)); ?></h1>
        </div>

        <div class="r-footer">
            <p>Thank you for your payment!</p>
            <p>System by Nithya</p>
        </div>
    </div>

    <div class="action-buttons">
        <button class="neu-btn btn-print" onclick="window.print()">
            <i class="bi bi-printer-fill"></i> Print
        </button>
        <button class="neu-btn btn-close" onclick="window.close()">
            <i class="bi bi-x-circle-fill"></i> Close
        </button>
    </div>

</div>

</body>
</html><?php /**PATH C:\Users\Supun\Desktop\EduGo_Live_Code\resources\views/receipt.blade.php ENDPATH**/ ?>