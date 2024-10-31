<?php
/**
 * This file has the styla that will be added into the head of the html file of
 * WooCommerce -> Optimus Price section.
 */

function optpr_style() {
  echo '<style>
    div.op-panel {
			border: 1px solid #e5e5e5;
			padding: 20px;
			border-radius: 5px;
    }
    div.op-panel-warning {
			background-color: #fcf8e3;
			color: #8a6d3b;
			border-color: #faebcc;
		}
		div.op-panel-ok {
			color: #3c763d;
			background-color: #dff0d8;
			border-color: #d6e9c6;
		}
		h1.op-title {
			font-size: xx-large;
		}
  </style>';
}

?>
