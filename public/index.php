<?php

// Gestion des routes basique
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajouter un produit
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $errors = [];
    if (empty($name)) $errors[] = "Le nom est obligatoire";
    if ($price <= 0) $errors[] = "Le prix doit être positif";

    if (empty($errors)) {
        $db->query(
            "INSERT INTO products (name, price, category) VALUES (?, ?, ?)",
            [$name, $price, $category]
        );
        header('Location: ?action=list&msg=added');
        exit;
    }
}

if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Modifier un produit
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $db->query(
        "UPDATE products SET name = ?, price = ?, category = ? WHERE id = ?",
        [$name, $price, $category, $id]
    );
    header('Location: ?action=list&msg=updated');
    exit;
}

if ($action === 'delete') {
    // Supprimer un produit
    $db->query("DELETE FROM products WHERE id = ?", [$id]);
    header('Location: ?action=list&msg=deleted');
    exit;
}

// Afficher la liste ou le formulaire

