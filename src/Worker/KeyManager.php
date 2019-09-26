<?php
/**
 * Created by PhpStorm.
 * User: Serge
 * Date: 02.09.2019
 * Time: 21:24
 */

namespace App\Worker;

use App\Entity\NumerologyUser;
use Doctrine\ORM\EntityManagerInterface;

class KeyManager
{
    public static function CheckEmail($email, EntityManagerInterface $entityManager){
        $user = $entityManager->getRepository(NumerologyUser::class)->findOneBy(['email' => $email]);
        if (!$user){
            return false;
        }
        return true;
    }

    public static function GetKeyByEmail($email, EntityManagerInterface $entityManager){
        $user = $entityManager->getRepository(NumerologyUser::class)->findOneBy(['email' => $email]);

        return $user->getSerial();
    }

    public static function AddEmail($email, EntityManagerInterface $entityManager){
        if (self::CheckEmail($email, $entityManager)){
            return self::GetKeyByEmail($email, $entityManager);
        }

        $key = self::generateKey();

        $user = new NumerologyUser();
        $user->setEmail($email);
        $user->setSerial($key);

        $entityManager->persist($user);
        $entityManager->flush();

        return $key;
    }

    public static function ProcessEmail($email, EntityManagerInterface $entityManager){
        if (self::CheckEmail($email, $entityManager)){
            return self::GetKeyByEmail($email, $entityManager);
        }
        else{
            return self::AddEmail($email, $entityManager);
        }
    }

    private static function generateKey(){
        $serials = [
            "6d93-8e6f-483b-9961",
            "0fb6-ace8-4a07-a85d",
            "1e64-c5f9-42d5-a629",
            "533b-7d55-4507-853e",
            "5166-74ee-41ad-9a76",
            "488e-9026-4f63-9513",
            "ce32-58f3-4d30-b703",
            "d1fe-a503-4ed8-a3c0",
            "8822-aee1-4f70-ac5c",
            "542d-5b1f-43a4-906b",
            "48bb-b745-44f5-8d19",
            "984d-83da-46c1-9da8",
            "2a85-bad1-42ca-bca9",
            "ef61-c4b4-4a7c-a4f2",
            "dc16-d2c9-49a1-8587",
            "ba9e-137f-44d5-8597",
            "28a0-1543-49e4-9c28",
            "9a8e-991e-4a45-9646",
            "8e9b-446f-4562-a114",
            "c88d-fc23-4dec-a944",
            "06f7-20b9-4998-a1a3",
            "67e8-2040-4058-85eb",
            "51d5-7e18-4615-8a95",
            "73f1-7844-43ac-a3b3",
            "04f5-9f1b-4e10-b587",
            "860e-a5bd-430c-9a0b",
            "2b23-bcec-4a6d-8c6a",
            "e34f-ce4d-4d05-b3bc",
            "2ffb-f986-4adb-9be0",
            "b0db-0e41-4625-a095",
            "d190-3e94-4f82-91f0",
            "996e-9928-46ce-a005",
            "ecbe-7770-40e0-a70f",
            "2ce4-f7a2-41cd-8ad4",
            "67c3-0d02-4087-bb38",
            "8a87-834f-4af3-831b",
            "5ada-096f-4c2d-8d3a",
            "8572-5f67-452c-b421",
            "5de6-5c67-4eaf-86a0",
            "eb1d-d769-4b88-86c4",
            "53d0-f966-4c23-ab9a",
            "f233-d40c-4f44-97d1",
            "8102-ee5a-4d5e-bd41",
            "6a26-e1d4-4a42-8e08",
            "ea63-d0c2-4241-a3d1",
            "6c35-3e55-488c-b470",
            "a02a-7d92-4dd8-a4ed",
            "e5a6-b313-4d0e-92ab",
            "34f9-e2d7-4489-9541",
            "9a05-78d2-491b-a8e5",
            "e27a-f9b4-4a8d-86ef",
            "1902-5b30-4b6f-8e40",
            "43d0-5cf2-4d24-a895",
            "80e0-98c8-4b38-aed6",
            "cbec-d971-4b42-b920",
            "94d5-c741-4f23-8c23",
            "4f6a-0dda-40b5-969c",
            "f891-a09f-4e45-9d17",
            "8ea4-db1b-4995-bc3d",
            "0a38-c576-4ca1-9868",
            "1154-c2fb-4bb7-bd61",
            "2763-7d58-49d2-9b1f",
            "ad83-b5ef-47b8-ba22",
            "9657-fd75-4b3e-b3cc",
            "c7c1-2d48-4570-886e",
            "9646-1c68-4499-b3a0",
            "84e0-2c27-471b-8785",
            "3c3a-9b66-42cc-8fc8",
            "b7f1-d15e-4e71-a5b8",
            "3dcd-d992-4374-a0c4",
            "69c5-8f7f-409d-82f1",
            "927e-ceb9-4630-b377",
            "edd3-c46e-41a1-9abf",
            "66c0-faba-4961-b62d",
            "c6df-af27-4932-9fcf",
            "9423-9960-4d2b-a571",
            "0ee3-c71e-4e76-8f23",
            "2b31-6666-42fa-981d",
            "6be0-1231-4eb4-b289",
            "ab0b-7e90-415a-a2b9",
            "d778-6677-415c-a6f3",
            "3144-a2e5-4885-9c4f",
            "3959-4bc4-4532-8d68",
            "dfdb-8806-4770-9bc9",
            "bb32-dc60-46ca-ac0b",
            "c767-32b7-42b8-af85",
            "f01a-a979-416b-913a",
            "a30a-a1af-4fc3-9994",
            "1466-da97-4fdb-a96b",
            "d37a-afa4-4350-be52",
            "955e-3e98-485d-bda5",
            "b32d-f82c-4935-867f",
            "5de5-ebb2-4f8a-ade2",
            "5e96-97da-41da-b787",
            "9090-e930-407b-9796",
            "f130-e8ea-4e0c-9f6e",
            "5c6c-dd39-4f73-9c39",
            "0b8d-1f6a-4cfb-a69c",
            "f7f0-673a-48d0-b210",
            "f1cc-87e6-46be-97dc"
        ];
        return $serials[rand(0, 99)];
    }
}