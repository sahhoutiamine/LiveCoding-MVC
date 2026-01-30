<!DOCTYPE html>
<html>
<head>
    <title>Gestion Produits</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .message { background: #d4edda; padding: 10px; margin: 10px 0; }
        .error { background: #f8d7da; padding: 10px; margin: 10px 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .form-group { margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Gestion des Produits</h1>

    <?php if (isset($_GET['msg'])): ?>
        <div class="message">
            <?php
            $messages = [
                'added' => 'Produit ajouté avec succès',
                'updated' => 'Produit modifié avec succès',
                'deleted' => 'Produit supprimé avec succès'
            ];
            echo $messages[$_GET['msg']] ?? '';
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <nav>
        <a href="?action=list">Liste</a> |
        <a href="?action=add_form">Ajouter</a>
    </nav>

    <?php if ($action === 'list'): ?>
        <h2>Liste des Produits</h2>
        <?php
        $stmt = $db->query("SELECT * FROM products ORDER BY created_at DESC");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if (empty($products)): ?>
            <p>Aucun produit trouvé.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo number_format($product['price'], 2); ?> €</td>
                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                        <td>
                            <a href="?action=edit_form&id=<?php echo $product['id']; ?>">Modifier</a> |
                            <a href="?action=delete&id=<?php echo $product['id']; ?>"
                               onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    <?php elseif ($action === 'add_form' || $action === 'edit_form'): ?>
        <h2><?php echo $action === 'add_form' ? 'Ajouter' : 'Modifier'; ?> un Produit</h2>

        <?php
        $product = ['name' => '', 'price' => '', 'category' => ''];
        if ($action === 'edit_form' && $id) {
            $stmt = $db->query("SELECT * FROM products WHERE id = ?", [$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC) ?: $product;
        }
        ?>

        <form method="POST" action="?action=<?php echo $action === 'add_form' ? 'add' : 'edit'; ?><?php echo $id ? '&id=' . $id : ''; ?>">
            <div class="form-group">
                <label>Nom:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Prix (€):</label>
                <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>

            <div class="form-group">
                <label>Catégorie:</label>
                <select name="category">
                    <option value="Electronique" <?php echo $product['category'] === 'Electronique' ? 'selected' : ''; ?>>Electronique</option>
                    <option value="Vêtements" <?php echo $product['category'] === 'Vêtements' ? 'selected' : ''; ?>>Vêtements</option>
                    <option value="Alimentation" <?php echo $product['category'] === 'Alimentation' ? 'selected' : ''; ?>>Alimentation</option>
                </select>
            </div>

            <button type="submit"><?php echo $action === 'add_form' ? 'Ajouter' : 'Modifier'; ?></button>
            <a href="?action=list">Annuler</a>
        </form>
    <?php endif; ?>
</body>
</html>
