package com.bootdo.epaper.dao;

import com.bootdo.epaper.domain.RectDO;

import java.util.List;
import java.util.Map;

import org.apache.ibatis.annotations.Mapper;

/**
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-12 18:40:04
 */
@Mapper
public interface RectDao {

	RectDO get(Integer id);
	
	List<RectDO> list(Map<String, Object> map);
	
	int count(Map<String, Object> map);
	
	int save(RectDO rect);
	
	int update(RectDO rect);
	
	int remove(Integer ID);
	
	int batchRemove(Integer[] ids);
}
