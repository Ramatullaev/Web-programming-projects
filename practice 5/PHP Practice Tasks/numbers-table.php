<?php

function isEven($n) {
  return $n % 2 === 0;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Numbers 1–20: Even or Odd</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; padding: 24px; }
    table { border-collapse: collapse; width: 340px; }
    th, td { border:1px solid #ccc; padding:8px 10px; text-align:left; }
    tr:nth-child(even) { background:#f7f7f7; }
    .even { color: #0b5; font-weight: 600; }
    .odd { color: #06c; font-weight: 600; }
  </style>
</head>
<body>
  <h1>Numbers from 1 to 20</h1>
  <table>
    <tr><th>#</th><th>Parity</th></tr>
    <?php for ($i = 1; $i <= 20; $i++): ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td class="<?php echo isEven($i) ? 'even' : 'odd'; ?>">
          <?php echo isEven($i) ? 'even' : 'odd'; ?>
        </td>
      </tr>
    <?php endfor; ?>
  </table>
</body>
</html>
