
                <table class="show-list">
                    <thead>
                        <tr>
	                        <th>Day</th>
                            <th>Date</th>
                            <th>Time</th>
	                        <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($event->shows as $show): ?>
                        <tr>
                            <td class="date-time">
                                <?=$show->shortDay?>
                            </td>
                            <td class="date-time">
                                <?=$show->longDate?>
                            </td>
                            <td class="date-time">
                                <?=$show->timeOfDay?>
                            </td>
                            <td class="location">
                                <a href="/venues/detail/<?=$show->venue->venue_id?>">
                                    <?=$show->venue->name?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>