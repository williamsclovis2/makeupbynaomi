<?php
/**
 * SERVICES SELECT BOX FOR ENTRIES - MULTI-SELECT VERSION
 * This file is included in entry forms
 * File name: services.php (or services.PL depending on your naming convention)
 * Location: views/includes/
 */

// Fetch active services
$serviceClass = new Service();
$serviceClass->getActiveServices();
$services = $serviceClass->data();
?>

<label class="form-label" for="service_type">Service Type(s) <span class="text-danger">*</span></label>
<select class="form-select" id="service_type" name="register-service_type[]" multiple required size="5">
    <?php 
    if($services && is_array($services)){
        foreach($services as $service){
            // Only show amount if it's greater than 0
            if($service->default_amount > 0) {
                $amount_formatted = number_format($service->default_amount, 0);
                $display_text = htmlspecialchars($service->service_name) . ' (UGX ' . $amount_formatted . ')';
            } else {
                $display_text = htmlspecialchars($service->service_name);
            }
    ?>
    <option value="<?= htmlspecialchars($service->service_name); ?>" 
            data-id="<?= $service->id; ?>"
            data-amount="<?= $service->default_amount; ?>">
        <?= $display_text; ?>
    </option>
    <?php 
        }
    } else {
    ?>
    <option value="" disabled>No active services available</option>
    <?php } ?>
    
    <!-- Add "Other" option at the end -->
    <option value="other" data-id="0" data-amount="0">Other (Specify)</option>
</select>
<small class="text-muted">Hold Ctrl / Cmd to select multiple services</small>

<!-- Hidden input for custom service name -->
<div id="other_service_container" style="display: none;" class="mt-2">
    <label class="form-label" for="other_service_name">Specify Custom Service Name <span class="text-danger">*</span></label>
    <input type="text" 
           class="form-control" 
           id="other_service_name" 
           name="register-other_service_name" 
           placeholder="Enter custom service name"
           disabled>
</div>

