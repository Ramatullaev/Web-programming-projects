<?php

$students = [
  ["name" => "Aruzhan", "grade" => 91],
  ["name" => "Ayan",    "grade" => 87],
  ["name" => "Dias",    "grade" => 78],
  ["name" => "Mira",    "grade" => 95],
  ["name" => "Sanzhar", "grade" => 82],
];

function getAverage($grades) {
  if (count($grades) === 0) return 0;
  $sum = 0;
  foreach ($grades as $g) { $sum += $g; }
  return $sum / count($grades);
}

$gradeValues = array_map(function($s){ return $s["grade"]; }, $students);
$avg = getAverage($gradeValues);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Students & Average Grade</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; padding: 24px; }
    table { border-collapse: collapse; min-width: 380px; }
    th, td { border:1px solid #ccc; padding:8px 10px; text-align:left; }
    th { background:#f0f6ff; }
    tfoot td { font-weight:700; }
  </style>
</head>
<body>
  <h1>Students</h1>
  <table>
    <thead><tr><th>Name</th><th>Grade</th></tr></thead>
    <tbody>
      <?php foreach ($students as $s): ?>
        <tr>
          <td><?php echo htmlspecialchars($s["name"]); ?></td>
          <td><?php echo $s["grade"]; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td>Average</td>
        <td><?php echo number_format($avg, 2); ?></td>
      </tr>
    </tfoot>
  </table>
</body>
</html>
