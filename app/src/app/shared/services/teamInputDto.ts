import {PlayersInputDto} from "./playersInputDto";

export interface TeamInputDto {
  id?: number;
  name?: string | null;
  shield?: string | null;
  players?: Array<PlayersInputDto> | null;
}
