<?php

class WorkerMatrixController {

    /**
     * Get matrix data for display
     */
    public static function getMatrixData() {
        try {
            $matrixClass = new WorkerMatrix();
            
            // Get filter parameters
            $user_id   = isset($_GET['user_id'])   && !empty($_GET['user_id'])   ? (int) $_GET['user_id']        : null;
            $from_date = isset($_GET['from_date']) && !empty($_GET['from_date']) ? $_GET['from_date']            : null;
            $to_date   = isset($_GET['to_date'])   && !empty($_GET['to_date'])   ? $_GET['to_date']              : null;
            
            // Build matrix
            $matrix_data = $matrixClass->buildMatrix($from_date, $to_date, $user_id);
            
            return (object) array(
                'ERRORS' => false,
                'data'   => $matrix_data
            );
            
        } catch (Exception $e) {
            return (object) array(
                'ERRORS'        => true,
                'ERRORS_SCRIPT' => $e->getMessage(),
                'data'          => null
            );
        }
    }

    /**
     * Get all active workers for the filter dropdown
     */
    public static function getWorkersList() {
        try {
            $db = DB::getInstance();
            $query = $db->query("
                SELECT ID, CONCAT(firstname, ' ', lastname) AS full_name
                FROM   app_users
                WHERE  state = 'activated'
                ORDER  BY firstname ASC
            ");
            return $query->count() ? $query->results() : array();
        } catch (Exception $e) {
            return array();
        }
    }

    /**
     * Export matrix to Excel (optional future feature)
     */
    public static function exportMatrix() {
        // TODO: Implement export functionality
    }
}

?>