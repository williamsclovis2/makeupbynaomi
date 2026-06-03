 <!-- JAVASCRIPT -->
<script src="<?= DNADMIN ?>/assets/libs/jquery/jquery.min.js"></script>
<script src="<?= DNADMIN ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= DNADMIN ?>/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= DNADMIN ?>/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= DNADMIN ?>/assets/libs/node-waves/waves.min.js"></script>


<!-- Peity chart-->
<script src="<?= DNADMIN ?>/assets/libs/peity/jquery.peity.min.js"></script>

<!-- Plugin Js-->
<script src="<?= DNADMIN ?>/assets/libs/chartist/chartist.min.js"></script>

<script src="<?= DNADMIN ?>/assets/js/pages/dashboard.init.js"></script>

<script src="<?= DNADMIN ?>/assets/js/app.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function updateTime() {
        const now = new Date();
        let hours = now.getHours();
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        const timeString = `${hours}:${minutes}:${seconds} ${ampm}`;
        
        document.getElementById('live-time').textContent = timeString;
    }

    // Update time immediately and then every second
    updateTime();
    setInterval(updateTime, 1000);

    // MODAL OPENNER 
     var liquidationModalEl = document.getElementById('liquidationModal');
    var liquidationModal = new bootstrap.Modal(liquidationModalEl);
    document.getElementById('openLiquidationModal').addEventListener('click', function() {
        liquidationModal.show();
    });
</script>

<script>
$(document).ready(function() {

    function updateWorkerShare() {
        let totalAmount = parseFloat($("#amount").val()) || 0;
        let collabAmounts = 0;
        
        $(".collab_input:visible:enabled").each(function() {
            collabAmounts += parseFloat($(this).val()) || 0;
        });
        
        let workerShare = totalAmount - collabAmounts;
        $("#user_final_amount").val(workerShare >= 0 ? workerShare.toFixed(2) : 0);
    }

    function styleInput($input) {
        if ($input.prop("disabled")) {
            $input.css({
                "background-color": "#e9ecef",
                "cursor": "not-allowed"
            });
        } else {
            $input.css({
                "background-color": "#fff",
                "cursor": "text"
            });
        }
    }

    // Initial style
    styleInput($("#coworkers"));
    $(".collab_input").each(function() {
        styleInput($(this));
    });

    // Collaboration checkbox
    $("#collaboration_check").change(function() {
        let enabled = $(this).is(":checked");
        $("#coworkers").prop("disabled", !enabled);
        styleInput($("#coworkers"));

        if (!enabled) {
            $("#coworkers").val([]);
            $(".collab-amount-row").hide();
            $(".collab_input").prop("disabled", true).val('');
            $(".collab_input").each(function() {
                styleInput($(this));
            });
            updateWorkerShare();
        }
    });

    // Coworkers selection
    $("#coworkers").change(function() {
        let selectedWorkers = $(this).val() || [];
        
        $(".collab-amount-row").hide();
        $(".collab_input").prop("disabled", true).val('');
        
        selectedWorkers.forEach(function(userId) {
            let $row = $(`.collab-amount-row[data-user-id="${userId}"]`);
            $row.show();
            $row.find(".collab_input").prop("disabled", false);
        });
        
        $(".collab_input").each(function() {
            styleInput($(this));
        });
        
        updateWorkerShare();
    });

    $("#amount").on("input", function() {
        updateWorkerShare();
    });

    $(".collab_input").on("input", function() {
        updateWorkerShare();
    });

    updateWorkerShare();
});
</script>

<!-- Other Action  -->
 <script>
// Handle "Other" service selection
document.addEventListener('DOMContentLoaded', function() {
    const serviceSelect = document.getElementById('service_type');
    const otherContainer = document.getElementById('other_service_container');
    const otherInput = document.getElementById('other_service_name');
    
    if (serviceSelect) {
        serviceSelect.addEventListener('change', function() {
            const selectedOptions = Array.from(this.selectedOptions);
            const hasOther = selectedOptions.some(opt => opt.value === 'other');
            
            if (hasOther) {
                otherContainer.style.display = 'block';
                otherInput.disabled = false;
                otherInput.required = true;
            } else {
                otherContainer.style.display = 'none';
                otherInput.disabled = true;
                otherInput.required = false;
                otherInput.value = '';
            }
        });
    }
});
</script>