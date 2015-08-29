<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2015 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

$web_path = AmpConfig::get('web_path');
$thcount = 8;
?>
<?php if ($browse->get_show_header()) require AmpConfig::get('prefix') . '/templates/list_header.inc.php'; ?>
<div class="tabledata" cellpadding="0" cellspacing="0" data-objecttype="album">
    
    <ul id="album-layout">
        <?php
        if (AmpConfig::get('ratings')) { Rating::build_cache('album',$object_ids); }
        if (AmpConfig::get('userflags')) { Userflag::build_cache('album',$object_ids); }

        $show_direct_play_cfg = AmpConfig::get('directplay');
        $directplay_limit = AmpConfig::get('direct_play_limit');

        /* Foreach through the albums */
        foreach ($object_ids as $album_id) {
            $libitem = new Album($album_id);
            $libitem->allow_group_disks = $allow_group_disks;
            $libitem->format(true, $limit_threshold);
            $show_direct_play = $show_direct_play_cfg;
            $show_playlist_add = Access::check('interface', '25');
            if ($directplay_limit > 0) {
                $show_playlist_add = ($libitem->song_count <= $directplay_limit);
                if ($show_direct_play) {
                    $show_direct_play = $show_playlist_add;
                }
            }
        ?>
        <li id="album_<?php echo $libitem->id; ?>" class="<?php echo UI::flip_class(); ?>">
            <?php require AmpConfig::get('prefix') . '/templates/show_album_row.inc.php'; ?>
        </li>
        <?php }?>
        <?php if (!count($object_ids)) { ?>
        <div class="<?php echo UI::flip_class(); ?>">
            <div colspan="<?php echo $thcount; ?>"><span class="nodata"><?php echo T_('No album found'); ?></span></div>
        </div>
        <?php } ?>
    </ul>
    
</div>

<?php show_table_render(); ?>
<?php if ($browse->get_show_header()) require AmpConfig::get('prefix') . '/templates/list_header.inc.php'; ?>
