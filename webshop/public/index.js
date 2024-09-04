const { MongoClient } = require('mongodb');

// MongoDB-Verbindungs-URL
const url = 'mongodb://localhost:27017';
const dbName = 'mydatabase'; // Ersetze dies durch deinen Datenbanknamen

async function main() {
  // Erstelle eine neue MongoClient-Instanz
  const client = new MongoClient(url, { useNewUrlParser: true, useUnifiedTopology: true });

  try {
    // Verbinde zum MongoDB-Server
    await client.connect();
    console.log('Verbunden mit MongoDB');

    // Greife auf die Datenbank zu
    const db = client.db(dbName);

    // Beispiel: Erstelle eine neue Sammlung und füge ein Dokument hinzu
    const collection = db.collection('mycollection');
    const result = await collection.insertOne({ name: 'Test', value: 123 });
    console.log('Dokument eingefügt:', result.insertedId);

    // Beispiel: Lese das Dokument aus
    const doc = await collection.findOne({ name: 'Test' });
    console.log('Gefundenes Dokument:', doc);

  } catch (err) {
    console.error('Fehler beim Verbinden mit MongoDB:', err);
  } finally {
    // Schließe die Verbindung
    await client.close();
    console.log('Verbindung zu MongoDB geschlossen');
  }
}

// Rufe die Hauptfunktion auf
main();
