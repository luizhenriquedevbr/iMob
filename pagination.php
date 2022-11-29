<?php if( ! empty($result['pageCount']) && $result['pageCount'] > 1): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- Previous Button -->
            <?php if(isset($result['previous'])): ?>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous" data-page="<?php echo $result['previous']; ?>">
                        <span class="page-link">&laquo;</span>
                        <span class="sr-only">Anterior</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">&laquo;</span>
                </li>
            <?php endif; ?>

            <?php if($result['startPage'] > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="#" data-page="1">1</a>
                </li>
                <?php if($result['startPage'] == 3): ?>
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="2">2</a>
                    </li>
                <?php elseif($result['startPage'] != 2): ?>
                <li class="page-item-disabled">
                    <span class="page-link">&hellip;</span>
                </li>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Range --> 
            <?php foreach ($result['pagesInRange'] as $page): ?>
                <?php if($page != $result['current']): ?>
                    <li class="page-item">
                        <a class="page-link" href="#" data-page="<?php echo $page; ?>"><?php echo $page; ?></a>
                    </li>
                <?php else: ?>
                    <li class="page-item active">
                        <span class="page-link"><?php echo $page; ?></span>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if($result['pageCount'] > $result['endPage']): ?>
                <?php if($result['pageCount'] > ($result['endPage'] + 1)): ?>
                    <?php if($result['pageCount'] > ($result['endPage'] + 2)): ?>
                        <li class="page-item-disabled">
                            <span class="page-link">&hellip;</span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="<?php echo $result['pageCount'] - 1; ?>"><?php echo $result['pageCount'] - 1; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <li class="page-item">
                    <a class="page-link" href="#" data-page="<?php echo $result['pageCount']; ?>"><?php echo $result['pageCount']; ?></a>
                </li>
            <?php endif; ?>
            
            <!-- Next Button -->
            <?php if(isset($result['next'])): ?>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next" data-page="<?php echo $result['next']; ?>">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item-disabled">
                    <span class="page-link">&raquo;</span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>