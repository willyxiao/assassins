<div class="row">
    <div class="small-8 small-centered columns">
        <table>
            <thead>
                <th>Name</th>
            </thead>
            <tbody>
                <?php foreach($alive_players as $alive_player): ?>
                    <tr>
                        <td><?= htmlspecialchars($alive_player) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
