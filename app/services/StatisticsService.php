<?php

class StatisticsService
{
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getVisitsStatistics($prisonId) {
    }
    public function getCrimeStatistics($prisonId) {
        try {
            $stmt = $this->db->prepare("SELECT crime, COUNT(*) as count FROM inmate WHERE id_prison = :id_prison GROUP BY crime ORDER BY crime");
            $stmt->bindParam(':id_prison', $prisonId, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $totalStmt = $this->db->prepare("SELECT COUNT(*) as total FROM inmate WHERE id_prison = :id_prison");
            $totalStmt->bindParam(':id_prison', $prisonId, PDO::PARAM_INT);
            $totalStmt->execute();
            $totalResult = $totalStmt->fetch(PDO::FETCH_ASSOC);
            $totalCrimes = $totalResult['total'];

            foreach ($results as &$result) {
                $result['percentage'] = ($result['count'] / $totalCrimes) * 100;
            }

            return $results;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return null;
        }
    }



    public function getAgeStatistics($prisonId) {
        try {
            $stmt = $this->db->prepare("SELECT age FROM inmate WHERE id_prison = :id_prison");
            $stmt->bindParam(':id_prison', $prisonId, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $totalStmt = $this->db->prepare("SELECT COUNT(*) as total FROM inmate WHERE id_prison = :id_prison");
            $totalStmt->bindParam(':id_prison', $prisonId, PDO::PARAM_INT);
            $totalStmt->execute();
            $totalResult = $totalStmt->fetch(PDO::FETCH_ASSOC);
            $totalInmates = $totalResult['total'];

            $ageGroups = [
                '20-30' => 0,
                '30-40' => 0,
                '40-50' => 0,
                '50-60' => 0,
                '60-70' => 0,
                '70-80' => 0,
                '80-90' => 0,
            ];

            foreach ($results as $result) {
                $age = $result['age'];
                if ($age >= 20 && $age < 30) {
                    $ageGroups['20-30']++;
                } elseif ($age >= 30 && $age < 40) {
                    $ageGroups['30-40']++;
                } elseif ($age >= 40 && $age < 50) {
                    $ageGroups['40-50']++;
                } elseif ($age >= 50 && $age < 60) {
                    $ageGroups['50-60']++;
                } elseif ($age >= 60 && $age < 70) {
                    $ageGroups['60-70']++;
                } elseif ($age >= 70 && $age < 80) {
                    $ageGroups['70-80']++;
                } elseif ($age >= 80 && $age < 90) {
                    $ageGroups['80-90']++;
                }
            }

            foreach ($ageGroups as $group => $count) {
                $ageGroups[$group] = [
                    'count' => $count,
                    'percentage' => ($count / $totalInmates) * 100
                ];
            }

            return $ageGroups;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return null;
        }
    }


    public function getGenderStatistics($prisonId){
        try {
            $stmt = $this->db->prepare("SELECT gender, COUNT(*) as count FROM inmate WHERE id_prison = :id_prison GROUP BY gender ORDER BY gender");
            $stmt->bindParam(':id_prison', $prisonId, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $totalStmt = $this->db->prepare("SELECT COUNT(*) as total FROM inmate WHERE id_prison = :id_prison");
            $totalStmt->bindParam(':id_prison', $prisonId, PDO::PARAM_INT);
            $totalStmt->execute();
            $totalResult = $totalStmt->fetch(PDO::FETCH_ASSOC);
            $totalCrimes = $totalResult['total'];

            foreach ($results as &$result) {
                $result['percentage'] = ($result['count'] / $totalCrimes) * 100;
            }

            return $results;
        } catch (PDOException $e) {
            trigger_error("Error in " . __METHOD__ . ": " . $e->getMessage(), E_USER_ERROR);
            return null;
        }
    }

    public function generateHTML($criteria, $prisonId) {
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename="statistics.html"');

        if ($criteria == 'crime category') {
            $crimeStatistics = $this->getCrimeStatistics($prisonId);

            echo '<table>';
            echo '<tr>';
            echo '<th>Crime</th>';
            echo '<th>Crime per Prison (%)</th>';
            echo '</tr>';
            foreach ($crimeStatistics as $statistic) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($statistic['crime']) . '</td>';
                echo '<td>' . number_format($statistic['percentage'], 2) . '%</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else if ($criteria == 'age group') {
            $ageStatistics = $this->getAgeStatistics($prisonId);

            echo '<table>';
            echo '<tr>';
            echo '<th>Age Group</th>';
            echo '<th>Age Group per Prison (%)</th>';
            echo '</tr>';
            foreach ($ageStatistics as $ageGroup => $statistic) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($ageGroup) . '</td>';
                echo '<td>' . number_format($statistic['percentage'], 2) . '%</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else if ($criteria == 'gender') {
            $genderStatistics = $this->getGenderStatistics($prisonId);

            echo '<table>';
            echo '<tr>';
            echo '<th>Gender</th>';
            echo '<th>Gender Group per Prison (%)</th>';
            echo '</tr>';
            foreach ($genderStatistics as $statistic) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($statistic['gender']) . '</td>';
                echo '<td>' . number_format($statistic['percentage'], 2) . '%</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {

            echo '<p>No data available for the selected criteria.</p>';
        }
    }



    public function generateJSON($criteria, $prisonId) {
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="statistics.json"');

        $statistics = null;
        if ($criteria == 'crime category') {
            $statistics = $this->getCrimeStatistics($prisonId);
        } else if ($criteria == 'age group') {
            $statistics = $this->getAgeStatistics($prisonId);
        } else if ($criteria == 'gender') {
            $statistics = $this->getGenderStatistics($prisonId);
        } else {
            $statistics = ['error' => 'No data available for the selected criteria.'];
        }

        echo json_encode($statistics);
    }


    public function generateCSV($criteria, $prisonId) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="statistics.csv"');

        $statistics = null;
        $header = [];

        if ($criteria == 'crime category') {
            $statistics = $this->getCrimeStatistics($prisonId);
            $header = ['Crime', 'Crime per Prison (%)'];
        } else if ($criteria == 'age group') {
            $statistics = $this->getAgeStatistics($prisonId);
            $header = ['Age Group', 'Age Group per Prison (%)'];
        } else if ($criteria == 'gender') {
            $statistics = $this->getGenderStatistics($prisonId);
            $header = ['Gender', 'Gender Group per Prison (%)'];
        }

        $output = fopen('php://output', 'w');
        fputcsv($output, $header);

        if ($statistics) {
            foreach ($statistics as $statistic) {
                if ($criteria == 'age group') {
                    fputcsv($output, [$statistic['age'], number_format($statistic['percentage'], 2) . '%']);
                } elseif ($criteria == 'gender') {
                    fputcsv($output, [$statistic['gender'], number_format($statistic['percentage'], 2) . '%']);
                } else {
                    fputcsv($output, [htmlspecialchars($statistic['crime']), number_format($statistic['percentage'], 2) . '%']);
                }
            }
        } else {
            fputcsv($output, ['No data available for the selected criteria.']);
        }

        fclose($output);
    }


}