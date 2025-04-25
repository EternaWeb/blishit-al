<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Add Product</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3665f3;
            --primary-dark: #2b4fb4;
            --light-gray: #f8f8f8;
            --border: #e5e5e5;
            --text: #333;
            --text-light: #767676;
            --success: #36b37e;
            --error: #e53238;
            --shadow: rgba(0, 0, 0, 0.05);
            --radius: 12px;
            --radius-sm: 8px;
            --radius-lg: 16px;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: var(--text);
            line-height: 1.5;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: var(--text-light);
            font-size: 16px;
        }

        /* Form Steps */
        .form-steps {
            display: flex;
            margin-bottom: 30px;
            background-color: white;
            border-radius: var(--radius);
            box-shadow: 0 2px 8px var(--shadow);
            padding: 20px;
            overflow-x: auto;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
            cursor: pointer;
            padding: 0 10px;
        }

        .step-number {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--light-gray);
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 8px;
            transition: all 0.3s;
            position: relative;
            z-index: 2;
        }

        .step.active .step-number {
            background-color: var(--primary);
            color: white;
        }

        .step.completed .step-number {
            background-color: var(--success);
            color: white;
        }

        .step-label {
            font-weight: 500;
            color: var(--text-light);
            transition: all 0.3s;
            text-align: center;
            font-size: 14px;
        }

        .step.active .step-label {
            color: var(--text);
            font-weight: 600;
        }

        .step.completed .step-label {
            color: var(--success);
        }

        .step-progress {
            position: absolute;
            top: 18px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--light-gray);
            z-index: 1;
        }

        .step:first-child .step-progress {
            left: 50%;
            width: 50%;
        }

        .step:last-child .step-progress {
            width: 50%;
        }

        .step.completed .step-progress {
            background-color: var(--success);
        }

        /* Form Container */
        .form-container {
            background-color: white;
            border-radius: var(--radius-lg);
            box-shadow: 0 2px 12px var(--shadow);
            padding: 30px;
            margin-bottom: 80px;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--text);
        }

        .required::after {
            content: "*";
            color: var(--error);
            margin-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            transition: all 0.2s;
            background-color: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(54, 101, 243, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 12px;
            background-color: white;
            transition: all 0.2s;
        }

        .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(54, 101, 243, 0.1);
        }

        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            min-height: 150px;
            resize: vertical;
            transition: all 0.2s;
            background-color: white;
        }

        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(54, 101, 243, 0.1);
        }

        /* Checkbox styles */
        .checkbox-group {
            margin-bottom: 15px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all 0.2s;
        }

        .checkbox-container:hover {
            background-color: var(--light-gray);
        }

        .checkbox-container input[type="checkbox"] {
            margin-right: 15px;
            width: 20px;
            height: 20px;
            accent-color: var(--primary);
        }

        .checkbox-label {
            flex: 1;
        }

        .shipping-details {
            color: var(--text-light);
            font-size: 14px;
            margin-top: 4px;
        }

        /* Keywords Bubbles */
        .keywords-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .keyword-bubble {
            display: inline-flex;
            align-items: center;
            background-color: var(--light-gray);
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 14px;
            color: var(--text);
            transition: all 0.2s;
        }

        .keyword-bubble:hover {
            background-color: rgba(54, 101, 243, 0.1);
        }

        .keyword-bubble .remove-keyword {
            margin-left: 6px;
            cursor: pointer;
            font-size: 16px;
            color: var(--text-light);
        }

        .keyword-bubble .remove-keyword:hover {
            color: var(--error);
        }

        /* Image Upload */
        .image-upload-container {
            margin-bottom: 20px;
        }

        .image-upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 15px;
            background-color: var(--light-gray);
        }

        .image-upload-area:hover {
            border-color: var(--primary);
            background-color: rgba(54, 101, 243, 0.05);
        }

        .image-upload-icon {
            font-size: 40px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .image-upload-text {
            font-size: 16px;
            color: var(--text);
            margin-bottom: 5px;
        }

        .image-upload-subtext {
            font-size: 14px;
            color: var(--text-light);
        }

        .image-upload-input {
            display: none;
        }

        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .image-preview-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1px solid var(--border);
            background-color: white;
        }

        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-actions {
            position: absolute;
            top: 0;
            right: 0;
            display: flex;
            gap: 5px;
            padding: 5px;
        }

        .image-action-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            color: var(--text);
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .image-action-btn:hover {
            transform: scale(1.1);
        }

        .image-action-btn.remove:hover {
            background-color: var(--error);
            color: white;
        }

        .image-action-btn.edit:hover {
            background-color: var(--primary);
            color: white;
        }

        .alt-text-container {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
        }

        .alt-text-container.active {
            display: block;
        }

        .alt-text-input {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid var(--border);
            font-size: 12px;
        }

        /* Specifications */
        .specs-container {
            margin-bottom: 20px;
        }

        .spec-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .spec-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .add-spec-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 16px;
            background-color: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 5px var(--shadow);
        }

        .add-spec-btn:hover {
            background-color: var(--light-gray);
            border-color: var(--primary);
        }

        .add-spec-btn span {
            margin-right: 5px;
            font-size: 18px;
        }

        /* Review Section */
        .review-section {
            margin-bottom: 20px;
            background-color: var(--light-gray);
            border-radius: var(--radius-sm);
            padding: 20px;
        }

        .review-heading {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }

        .review-item {
            display: flex;
            margin-bottom: 15px;
        }

        .review-label {
            width: 200px;
            font-weight: 500;
            color: var(--text-light);
        }

        .review-value {
            flex: 1;
        }

        .review-images {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .review-image {
            width: 80px;
            height: 80px;
            border-radius: 4px;
            object-fit: cover;
        }

        .review-specs {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }

        .review-spec {
            padding: 10px;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px var(--shadow);
        }

        .review-spec-key {
            font-weight: 500;
            margin-bottom: 5px;
        }

        /* Form Actions */
        .form-actions {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            padding: 0 20px;
            display: flex;
            justify-content: center;
            max-width: 1000px;
            margin: 0 auto;
            z-index: 100;
        }

        .form-actions-container {
            display: flex;
            justify-content: space-between;
            background-color: white;
            border-radius: 30px;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 24px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: white;
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background-color: var(--light-gray);
        }

        /* Success message */
        .success-message {
            text-align: center;
            padding: 40px 20px;
        }

        .success-icon {
            font-size: 60px;
            color: var(--success);
            margin-bottom: 20px;
        }

        .success-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .success-text {
            font-size: 16px;
            color: var(--text-light);
            margin-bottom: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .form-container {
                padding: 20px;
            }

            .step-label {
                font-size: 12px;
            }

            .form-actions {
                position: static;
                margin-top: 30px;
                padding: 0;
            }

            .form-actions-container {
                border-radius: var(--radius-sm);
            }

            .spec-row {
                flex-direction: column;
                gap: 15px;
            }

            .review-item {
                flex-direction: column;
            }

            .review-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Add a Product</h1>
            <p class="page-subtitle">Fill in the details below to list your product</p>
        </div>

        <div class="form-steps">
            <div class="step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Basic Info</div>
                <div class="step-progress"></div>
            </div>
            <div class="step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Details & Shipping</div>
                <div class="step-progress"></div>
            </div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Images</div>
                <div class="step-progress"></div>
            </div>
            <div class="step" data-step="4">
                <div class="step-number">4</div>
                <div class="step-label">Specifications</div>
                <div class="step-progress"></div>
            </div>
        </div>

        <form id="product-form" class="product-form">
            <div class="form-container">
                <!-- Step 1: Basic Information -->
                <div class="form-section active" data-section="1">
                    <h2 class="section-title">Basic Information</h2>
                    
                    <div class="form-group">
                        <label for="category" class="form-label required">Category</label>
                        <select id="category" class="form-select" required>
                            <option value="">Select a category</option>
                            <option value="electronics">Electronics</option>
                            <option value="automotive">Automotive</option>
                            <option value="fashion">Fashion</option>
                            <option value="home">Home & Garden</option>
                            <option value="sports">Sports</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subcategory" class="form-label required">Subcategory</label>
                        <select id="subcategory" class="form-select" required disabled>
                            <option value="">Select a subcategory</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="brand" class="form-label required">Brand</label>
                        <select id="brand" class="form-select" required disabled>
                            <option value="">Select a brand</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="model" class="form-label required">Model</label>
                        <select id="model" class="form-select" required disabled>
                            <option value="">Select a model</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title" class="form-label required">Product Title</label>
                        <input type="text" id="title" class="form-input" placeholder="e.g., iPhone 16 Pro Max 256GB Black - Like New" required>
                    </div>

                    <div class="form-group">
                        <label for="condition" class="form-label required">Condition</label>
                        <select id="condition" class="form-select" required>
                            <option value="">Select condition</option>
                            <option value="new">New</option>
                            <option value="like-new">Like New</option>
                            <option value="good">Good</option>
                            <option value="fair">Fair</option>
                            <option value="solid">Solid</option>
                            <option value="bad">Bad</option>
                        </select>
                    </div>
                </div>

                <!-- Step 2: Details & Shipping -->
                <div class="form-section" data-section="2">
                    <h2 class="section-title">Details & Shipping</h2>
                    
                    <div class="form-group">
                        <label for="location" class="form-label required">Location</label>
                        <select id="location" class="form-select" required>
                            <option value="">Select location</option>
                            <option value="new-york">New York</option>
                            <option value="los-angeles">Los Angeles</option>
                            <option value="chicago">Chicago</option>
                            <option value="houston">Houston</option>
                            <option value="miami">Miami</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Shipping Options</label>
                        <p style="margin-bottom: 15px; color: var(--text-light);">Select at least one shipping option</p>
                        
                        <div class="checkbox-group" id="shipping-options">
                            <div class="checkbox-container">
                                <input type="checkbox" id="shipping-1" name="shipping" value="standard">
                                <div class="checkbox-label">
                                    <div>Standard Shipping</div>
                                    <div class="shipping-details">$5 to Chicago, $7 to Boston</div>
                                </div>
                            </div>
                            <div class="checkbox-container">
                                <input type="checkbox" id="shipping-2" name="shipping" value="express">
                                <div class="checkbox-label">
                                    <div>Express Shipping</div>
                                    <div class="shipping-details">$12 to Chicago, $15 to Boston</div>
                                </div>
                            </div>
                            <div class="checkbox-container">
                                <input type="checkbox" id="shipping-3" name="shipping" value="next-day">
                                <div class="checkbox-label">
                                    <div>Next Day Delivery</div>
                                    <div class="shipping-details">$20 to Chicago, $25 to Boston</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keywords" class="form-label">Keywords</label>
                        <input type="text" id="keywords" class="form-input" placeholder="Type keywords and press Tab to add">
                        <div class="keywords-container" id="keywords-container">
                            <!-- Keywords will be added here -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label required">Description</label>
                        <textarea id="description" class="form-textarea" placeholder="Describe the product, its condition, and any additional details." required></textarea>
                    </div>
                </div>

                <!-- Step 3: Images -->
                <div class="form-section" data-section="3">
                    <h2 class="section-title">Product Images</h2>
                    
                    <div class="form-group">
                        <label class="form-label required">Upload Images</label>
                        <div class="image-upload-container">
                            <div class="image-upload-area" id="image-upload-area">
                                <div class="image-upload-icon">📷</div>
                                <div class="image-upload-text">Drag & drop images here or click to browse</div>
                                <div class="image-upload-subtext">Upload at least one image (JPEG, PNG, max 5MB each)</div>
                                <input type="file" id="image-upload" class="image-upload-input" accept="image/*" multiple>
                            </div>
                            <div class="image-preview-container" id="image-preview-container">
                                <!-- Image previews will be added here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Specifications & Review -->
                <div class="form-section" data-section="4">
                    <h2 class="section-title">Product Specifications</h2>
                    
                    <div class="specs-container" id="specs-container">
                        <div class="spec-row">
                            <div class="form-group">
                                <label for="spec-key-1" class="form-label">Specification</label>
                                <input type="text" id="spec-key-1" class="form-input spec-key" value="Weight" readonly>
                            </div>
                            <div class="form-group">
                                <label for="spec-value-1" class="form-label">Value</label>
                                <input type="text" id="spec-value-1" class="form-input spec-value" placeholder="e.g., 240g">
                            </div>
                        </div>
                        <div class="spec-row">
                            <div class="form-group">
                                <label for="spec-key-2" class="form-label">Specification</label>
                                <input type="text" id="spec-key-2" class="form-input spec-key" value="Color" readonly>
                            </div>
                            <div class="form-group">
                                <label for="spec-value-2" class="form-label">Value</label>
                                <input type="text" id="spec-value-2" class="form-input spec-value" placeholder="e.g., Black">
                            </div>
                        </div>
                        <div class="spec-row">
                            <div class="form-group">
                                <label for="spec-key-3" class="form-label">Specification</label>
                                <input type="text" id="spec-key-3" class="form-input spec-key" value="Dimensions" readonly>
                            </div>
                            <div class="form-group">
                                <label for="spec-value-3" class="form-label">Value</label>
                                <input type="text" id="spec-value-3" class="form-input spec-value" placeholder="e.g., 6.3 x 3.0 x 0.3 in">
                            </div>
                        </div>
                        <div class="spec-row">
                            <div class="form-group">
                                <label for="spec-key-4" class="form-label">Specification</label>
                                <input type="text" id="spec-key-4" class="form-input spec-key" value="Material" readonly>
                            </div>
                            <div class="form-group">
                                <label for="spec-value-4" class="form-label">Value</label>
                                <input type="text" id="spec-value-4" class="form-input spec-value" placeholder="e.g., Aluminum">
                            </div>
                        </div>
                        <div class="spec-row">
                            <div class="form-group">
                                <label for="spec-key-5" class="form-label">Specification</label>
                                <input type="text" id="spec-key-5" class="form-input spec-key" value="Warranty" readonly>
                            </div>
                            <div class="form-group">
                                <label for="spec-value-5" class="form-label">Value</label>
                                <input type="text" id="spec-value-5" class="form-input spec-value" placeholder="e.g., 1 year">
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="add-spec-btn" id="add-spec-btn">
                        <span>+</span> Add Another Specification
                    </button>
                    
                    <h2 class="section-title" style="margin-top: 30px;">Review Your Listing</h2>
                    
                    <div class="review-section">
                        <h3 class="review-heading">Product Summary</h3>
                        <div id="review-content">
                            <!-- Review content will be populated dynamically -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="form-actions-container">
                    <button type="button" id="prev-btn" class="btn btn-secondary" disabled>Back</button>
                    <button type="button" id="next-btn" class="btn btn-primary">Continue</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form navigation
            const steps = document.querySelectorAll('.step');
            const sections = document.querySelectorAll('.form-section');
            const nextBtn = document.getElementById('next-btn');
            const prevBtn = document.getElementById('prev-btn');
            let currentStep = 1;
            
            // Update form navigation
            function updateFormNavigation() {
                // Update steps
                steps.forEach(step => {
                    const stepNum = parseInt(step.dataset.step);
                    step.classList.remove('active', 'completed');
                    
                    if (stepNum === currentStep) {
                        step.classList.add('active');
                    } else if (stepNum < currentStep) {
                        step.classList.add('completed');
                    }
                });
                
                // Update sections
                sections.forEach(section => {
                    section.classList.remove('active');
                    if (parseInt(section.dataset.section) === currentStep) {
                        section.classList.add('active');
                    }
                });
                
                // Update buttons
                prevBtn.disabled = currentStep === 1;
                nextBtn.textContent = currentStep === 4 ? 'Submit Listing' : 'Continue';
                
                // Scroll to top
                window.scrollTo(0, 0);
            }
            
            // Next button click
            nextBtn.addEventListener('click', function() {
                if (currentStep < 4) {
                    currentStep++;
                    updateFormNavigation();
                    
                    // If on the last step, update review content
                    if (currentStep === 4) {
                        updateReviewContent();
                    }
                } else {
                    // Submit form
                    submitForm();
                }
            });
            
            // Previous button click
            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateFormNavigation();
                }
            });
            
            // Step click navigation
            steps.forEach(step => {
                step.addEventListener('click', function() {
                    const stepNum = parseInt(this.dataset.step);
                    if (stepNum < currentStep) {
                        currentStep = stepNum;
                        updateFormNavigation();
                    }
                });
            });
            
            // Category cascade
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('subcategory');
            const brandSelect = document.getElementById('brand');
            const modelSelect = document.getElementById('model');
            
            // Mock data for dropdowns
            const subcategories = {
                'electronics': ['Mobile Phones', 'Laptops', 'Audio'],
                'automotive': ['Cars', 'Motorcycles', 'Parts & Accessories'],
                'fashion': ['Men\'s Clothing', 'Women\'s Clothing', 'Jewelry'],
                'home': ['Furniture', 'Garden', 'Home Decor'],
                'sports': ['Fitness', 'Outdoor', 'Team Sports']
            };
            
            const brands = {
                'Mobile Phones': ['Apple', 'Samsung', 'Google'],
                'Laptops': ['Dell', 'HP', 'Apple'],
                'Cars': ['Toyota', 'Honda', 'Ford']
            };
            
            const models = {
                'Apple': ['iPhone 16 Pro Max', 'iPhone 16', 'iPhone 15'],
                'Samsung': ['Galaxy S24 Ultra', 'Galaxy S24', 'Galaxy Z Fold 5'],
                'Toyota': ['Corolla', 'Camry', 'RAV4']
            };
            
            // Category change
            categorySelect.addEventListener('change', function() {
                const category = this.value;
                
                // Clear and disable subsequent dropdowns
                subcategorySelect.innerHTML = '<option value="">Select a subcategory</option>';
                brandSelect.innerHTML = '<option value="">Select a brand</option>';
                modelSelect.innerHTML = '<option value="">Select a model</option>';
                
                brandSelect.disabled = true;
                modelSelect.disabled = true;
                
                if (category) {
                    // Enable and populate subcategory
                    subcategorySelect.disabled = false;
                    
                    const categorySubcategories = subcategories[category] || [];
                    categorySubcategories.forEach(subcat => {
                        const option = document.createElement('option');
                        option.value = subcat.toLowerCase().replace(/\s+/g, '-');
                        option.textContent = subcat;
                        subcategorySelect.appendChild(option);
                    });
                } else {
                    subcategorySelect.disabled = true;
                }
            });
            
            // Subcategory change
            subcategorySelect.addEventListener('change', function() {
                const subcategory = this.options[this.selectedIndex].text;
                
                // Clear and disable subsequent dropdowns
                brandSelect.innerHTML = '<option value="">Select a brand</option>';
                modelSelect.innerHTML = '<option value="">Select a model</option>';
                
                modelSelect.disabled = true;
                
                if (subcategory) {
                    // Enable and populate brand
                    brandSelect.disabled = false;
                    
                    const subcategoryBrands = brands[subcategory] || [];
                    subcategoryBrands.forEach(brand => {
                        const option = document.createElement('option');
                        option.value = brand.toLowerCase().replace(/\s+/g, '-');
                        option.textContent = brand;
                        brandSelect.appendChild(option);
                    });
                } else {
                    brandSelect.disabled = true;
                }
            });
            
            // Brand change
            brandSelect.addEventListener('change', function() {
                const brand = this.options[this.selectedIndex].text;
                
                // Clear model dropdown
                modelSelect.innerHTML = '<option value="">Select a model</option>';
                
                if (brand) {
                    // Enable and populate model
                    modelSelect.disabled = false;
                    
                    const brandModels = models[brand] || [];
                    brandModels.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.toLowerCase().replace(/\s+/g, '-');
                        option.textContent = model;
                        modelSelect.appendChild(option);
                    });
                } else {
                    modelSelect.disabled = true;
                }
            });
            
            // Keywords bubbles
            const keywordsInput = document.getElementById('keywords');
            const keywordsContainer = document.getElementById('keywords-container');
            let keywords = [];
            
            keywordsInput.addEventListener('keydown', function(e) {
                if (e.key === 'Tab' || e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    
                    const keyword = this.value.trim();
                    if (keyword && !keywords.includes(keyword)) {
                        keywords.push(keyword);
                        renderKeywords();
                    }
                    
                    this.value = '';
                }
            });
            
            function renderKeywords() {
                keywordsContainer.innerHTML = '';
                
                keywords.forEach((keyword, index) => {
                    const bubble = document.createElement('div');
                    bubble.className = 'keyword-bubble';
                    bubble.innerHTML = `
                        ${keyword}
                        <span class="remove-keyword" data-index="${index}">&times;</span>
                    `;
                    keywordsContainer.appendChild(bubble);
                });
                
                // Add click event to remove buttons
                document.querySelectorAll('.remove-keyword').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.dataset.index);
                        keywords.splice(index, 1);
                        renderKeywords();
                    });
                });
            }
            
            // Image upload
            const imageUploadArea = document.getElementById('image-upload-area');
            const imageUploadInput = document.getElementById('image-upload');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            let images = [];
            
            imageUploadArea.addEventListener('click', function() {
                imageUploadInput.click();
            });
            
            imageUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--primary)';
                this.style.backgroundColor = 'rgba(54, 101, 243, 0.05)';
            });
            
            imageUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--border)';
                this.style.backgroundColor = 'var(--light-gray)';
            });
            
            imageUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--border)';
                this.style.backgroundColor = 'var(--light-gray)';
                
                if (e.dataTransfer.files.length) {
                    handleFiles(e.dataTransfer.files);
                }
            });
            
            imageUploadInput.addEventListener('change', function() {
                if (this.files.length) {
                    handleFiles(this.files);
                }
            });
            
            function handleFiles(files) {
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const imageId = Date.now() + Math.random().toString(36).substr(2, 5);
                            images.push({
                                id: imageId,
                                src: e.target.result,
                                alt: '',
                                file: file
                            });
                            
                            renderImages();
                        };
                        
                        reader.readAsDataURL(file);
                    }
                });
            }
            
            function renderImages() {
                imagePreviewContainer.innerHTML = '';
                
                images.forEach(image => {
                    const imageItem = document.createElement('div');
                    imageItem.className = 'image-preview-item';
                    imageItem.innerHTML = `
                        <img src="${image.src}" alt="${image.alt || 'Product image'}" class="image-preview">
                        <div class="image-preview-actions">
                            <button type="button" class="image-action-btn edit" data-id="${image.id}">+</button>
                            <button type="button" class="image-action-btn remove" data-id="${image.id}">×</button>
                        </div>
                        <div class="alt-text-container" id="alt-container-${image.id}">
                            <input type="text" class="alt-text-input" placeholder="Add alt text description" value="${image.alt}" data-id="${image.id}">
                        </div>
                    `;
                    imagePreviewContainer.appendChild(imageItem);
                });
                
                // Add event listeners to buttons
                document.querySelectorAll('.image-action-btn.remove').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const imageId = this.dataset.id;
                        images = images.filter(img => img.id !== imageId);
                        renderImages();
                    });
                });
                
                document.querySelectorAll('.image-action-btn.edit').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const imageId = this.dataset.id;
                        const altContainer = document.getElementById(`alt-container-${imageId}`);
                        altContainer.classList.toggle('active');
                        
                        if (altContainer.classList.contains('active')) {
                            altContainer.querySelector('input').focus();
                        }
                    });
                });
                
                document.querySelectorAll('.alt-text-input').forEach(input => {
                    input.addEventListener('blur', function() {
                        const imageId = this.dataset.id;
                        const altText = this.value.trim();
                        
                        // Update alt text
                        images = images.map(img => {
                            if (img.id === imageId) {
                                return { ...img, alt: altText };
                            }
                            return img;
                        });
                        
                        // Hide container
                        document.getElementById(`alt-container-${imageId}`).classList.remove('active');
                    });
                    
                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            this.blur();
                        }
                    });
                });
            }
            
            // Add specification
            const addSpecBtn = document.getElementById('add-spec-btn');
            const specsContainer = document.getElementById('specs-container');
            let specCount = 5;
            
            addSpecBtn.addEventListener('click', function() {
                specCount++;
                
                const specRow = document.createElement('div');
                specRow.className = 'spec-row';
                specRow.innerHTML = `
                    <div class="form-group">
                        <label for="spec-key-${specCount}" class="form-label">Specification</label>
                        <input type="text" id="spec-key-${specCount}" class="form-input spec-key" placeholder="e.g., Storage">
                    </div>
                    <div class="form-group">
                        <label for="spec-value-${specCount}" class="form-label">Value</label>
                        <input type="text" id="spec-value-${specCount}" class="form-input spec-value" placeholder="e.g., 256GB">
                    </div>
                `;
                
                specsContainer.appendChild(specRow);
            });
            
            // Update review content
            function updateReviewContent() {
                const reviewContent = document.getElementById('review-content');
                
                // Get form values
                const category = categorySelect.options[categorySelect.selectedIndex]?.text || '';
                const subcategory = subcategorySelect.options[subcategorySelect.selectedIndex]?.text || '';
                const brand = brandSelect.options[brandSelect.selectedIndex]?.text || '';
                const model = modelSelect.options[modelSelect.selectedIndex]?.text || '';
                const title = document.getElementById('title').value;
                const condition = document.getElementById('condition').options[document.getElementById('condition').selectedIndex]?.text || '';
                const location = document.getElementById('location').options[document.getElementById('location').selectedIndex]?.text || '';
                const description = document.getElementById('description').value;
                
                // Get shipping options
                const shippingOptions = [];
                document.querySelectorAll('input[name="shipping"]:checked').forEach(checkbox => {
                    const label = checkbox.nextElementSibling.querySelector('div:first-child').textContent;
                    shippingOptions.push(label);
                });
                
                // Get specifications
                const specs = [];
                document.querySelectorAll('.spec-row').forEach(row => {
                    const key = row.querySelector('.spec-key').value;
                    const value = row.querySelector('.spec-value').value;
                    
                    if (key && value) {
                        specs.push({ key, value });
                    }
                });
                
                // Build review HTML
                let reviewHTML = `
                    <div class="review-item">
                        <div class="review-label">Category</div>
                        <div class="review-value">${category} > ${subcategory}</div>
                    </div>
                    <div class="review-item">
                        <div class="review-label">Brand & Model</div>
                        <div class="review-value">${brand} ${model}</div>
                    </div>
                    <div class="review-item">
                        <div class="review-label">Title</div>
                        <div class="review-value">${title}</div>
                    </div>
                    <div class="review-item">
                        <div class="review-label">Condition</div>
                        <div class="review-value">${condition}</div>
                    </div>
                    <div class="review-item">
                        <div class="review-label">Location</div>
                        <div class="review-value">${location}</div>
                    </div>
                `;
                
                if (shippingOptions.length) {
                    reviewHTML += `
                        <div class="review-item">
                            <div class="review-label">Shipping Options</div>
                            <div class="review-value">${shippingOptions.join(', ')}</div>
                        </div>
                    `;
                }
                
                if (keywords.length) {
                    reviewHTML += `
                        <div class="review-item">
                            <div class="review-label">Keywords</div>
                            <div class="review-value">${keywords.join(', ')}</div>
                        </div>
                    `;
                }
                
                reviewHTML += `
                    <div class="review-item">
                        <div class="review-label">Description</div>
                        <div class="review-value">${description}</div>
                    </div>
                `;
                
                if (images.length) {
                    reviewHTML += `
                        <div class="review-item">
                            <div class="review-label">Images</div>
                            <div class="review-value">
                                <div class="review-images">
                                    ${images.map(img => `<img src="${img.src}" alt="${img.alt || 'Product image'}" class="review-image">`).join('')}
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                if (specs.length) {
                    reviewHTML += `
                        <div class="review-item">
                            <div class="review-label">Specifications</div>
                            <div class="review-value">
                                <div class="review-specs">
                                    ${specs.map(spec => `
                                        <div class="review-spec">
                                            <div class="review-spec-key">${spec.key}</div>
                                            <div>${spec.value}</div>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                reviewContent.innerHTML = reviewHTML;
            }
            
            // Submit form
            function submitForm() {
                // Here you would typically send the data to your server
                // For demo purposes, we'll just show a success message
                
                const formContainer = document.querySelector('.form-container');
                formContainer.innerHTML = `
                    <div class="success-message">
                        <div class="success-icon">✓</div>
                        <h2 class="success-title">Product Listed Successfully!</h2>
                        <p class="success-text">Your product has been added to the marketplace.</p>
                        <button type="button" class="btn btn-primary" onclick="window.location.reload()">Add Another Product</button>
                    </div>
                `;
                
                // Hide form actions
                document.querySelector('.form-actions').style.display = 'none';
                
                // Log form data to console
                console.log('Form submitted with data:', {
                    category: categorySelect.value,
                    subcategory: subcategorySelect.value,
                    brand: brandSelect.value,
                    model: modelSelect.value,
                    title: document.getElementById('title').value,
                    condition: document.getElementById('condition').value,
                    location: document.getElementById('location').value,
                    shippingOptions: Array.from(document.querySelectorAll('input[name="shipping"]:checked')).map(el => el.value),
                    keywords,
                    description: document.getElementById('description').value,
                    images,
                    specifications: Array.from(document.querySelectorAll('.spec-row')).map(row => ({
                        key: row.querySelector('.spec-key').value,
                        value: row.querySelector('.spec-value').value
                    }))
                });
            }
        });
    </script>
</body>
</html>

