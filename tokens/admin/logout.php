<?php session_start(); if(session_destroy()) { echo"<script>window.location.href = 'index.php';</script>"; } ?>
